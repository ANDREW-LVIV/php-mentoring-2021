<?php

namespace App\Controller;

use App\Entity\Notes;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NotesController extends AbstractController
{

    /**
     * @Route("/{page}", name="main", requirements={"page"="\d+"})
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param int $page
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(Request $request, $page = 1)
    {
        $order = $request->get('order') ?? 'ASC';

        $previous_page = false;
        $next_page = false;
        $offset = 0;
        $limit = 5;

        if ($page > 1) {
            $offset += $limit * ($page - 1);
            $previous_page = $page - 1;
        }

        $repository = $this->getDoctrine()->getRepository(Notes::class);
        $records = $repository->findBy(
          [],
          ['id' => $order],
          $limit + 1,
          $offset
        );

        if (count($records) > $limit) {
            $next_page = $page + 1;
            array_pop($records);
        }

        return $this->render(
          'index.html.twig',
          [
            'order' => $order,
            'page' => $page,
            'previous_page' => $previous_page,
            'next_page' => $next_page,
            'records' => $records,
          ]
        );
    }

    /**
     * @Route("/search", name="search_page")
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @param \Doctrine\ORM\EntityManagerInterface $entityManager
     *
     * @return Response
     */
    public function search(
      Request $request,
      EntityManagerInterface $entityManager
    ): Response {
        $word = $request->get('word');
        $repository = $this->getDoctrine()->getRepository(Notes::class);
        $records = $repository->findByMsgField($word);
        return $this->render(
          'search.html.twig',
          [
            'word' => $word,
            'records' => $records,
          ]
        );
    }

    /**
     * @Route("/task", name="task")
     */
    public function task()
    {
        return $this->render('task.html.twig');
    }

    /**
     * @Route("/add", name="add", methods="POST")
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \Doctrine\ORM\EntityManagerInterface $entityManager
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function create(
      Request $request,
      EntityManagerInterface $entityManager
    ) {
        if(empty($request->get('title')) OR empty($request->get('msg'))) {
            return $this->redirectToRoute('main');
        }
        $record = new Notes();
        $record->setTitle($request->get('title'))
          ->setMsg($request->get('msg'))
          ->setTimestamp(new DateTime("now"));
        $entityManager->persist($record);
        $entityManager->flush();

        return $this->redirectToRoute('main');
    }

    /**
     * @Route("/edit/{id}", name="edit")
     * @param int $id
     */
    public function edit(int $id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $record = $entityManager->getRepository(Notes::class)->find($id);

        return $this->render(
          'edit.html.twig',
          [
            'record' => $record,
          ]
        );
    }

    /**
     * @Route("/update/{id}", name="update", methods="POST")
     * @param $id
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \Doctrine\ORM\EntityManagerInterface $entityManager
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function update(
      $id,
      Request $request,
      EntityManagerInterface $entityManager
    ) {
        $entityManager = $this->getDoctrine()->getManager();
        $record = $entityManager->getRepository(Notes::class)->find($id);
        if (!$record) {
            throw $this->createNotFoundException(
              'No record found for id ' . $id
            );
        }

        $record->setTitle($request->get('title'))
          ->setMsg($request->get('msg'));
        $entityManager->flush();

        return $this->redirectToRoute('main');
    }

    /**
     * @Route("/delete/{id}", name="delete")
     * @param int $id
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function delete(int $id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $record = $entityManager->getRepository(Notes::class)->find($id);
        $entityManager->remove($record);
        $entityManager->flush();

        return $this->redirectToRoute('main');
    }

}
