<?php

# *** Observer ***
# Write a program that scans a given text and shows details about it.
# The program should notify any registered listeners with each word scanned.
# Types of listeners that are required:
# - Word counter – that simply counts the total words sent to it.
# - Number counter – that count the total numbers of string that represents numbers (for example "345", "0")
# - Longest word keeper – which keeps the last longest word sent to it
# - Reverse word – which reverses chars order in every given word

interface SubjectInterface
{

  /**
   * @param Observer $observer
   *
   * @return mixed
   */
  public function addObserver(Observer $observer);

  /**
   * @param Observer $observer
   *
   * @return mixed
   */
  public function removeObserver(Observer $observer);

  /**
   * Execute methods Observer::handleEvent for all observers
   *
   * @return void
   */
  public function notifyObservers();

  /**
   * @param string $text
   *
   * @return mixed
   */
  public function addText(string $text);

  /**
   * @return mixed
   */
  public function numberOfWords();

  /**
   * @return mixed
   */
  public function numberOfStrings();

  /**
   * @return mixed
   */
  public function longestWordKeeper();

  /**
   * @return mixed
   */
  public function reverseWord();

}

interface Observer
{

  /**
   * @param SubjectInterface $observable
   *
   * @return mixed
   */
  public function handleEvent(SubjectInterface $observable);

}

class WordScanner implements SubjectInterface
{

  /**
   * @var Observer[]
   */
  protected $observers = [];

  private $text;

  private $longestWordArray;

  /**
   * @param Observer $observer
   *
   * @return mixed
   */
  public function addObserver(Observer $observer)
  {
    echo '<b>' . get_class($observer) . ' added</b><br>';
    $this->observers[get_class($observer)] = $observer;
  }

  /**
   * @param Observer $observer
   *
   * @return mixed
   */
  public function removeObserver(Observer $observer)
  {
    echo '<b>' . get_class($observer) . ' remove</b><br>';
    unset($this->observers[get_class($observer)]);
  }

  /**
   * Execute methods Observer::handleEvent for all observers
   *
   * @return void
   */
  public function notifyObservers()
  {
    foreach ($this->observers as $observer) {
      $observer->handleEvent($this);
    }
  }

  /**
   * @param string $text
   *
   * @return mixed|void
   */
  public function addText(string $text)
  {
    $this->text = $text;
    $this->notifyObservers();
  }

  /**
   * @return int
   */
  public function numberOfWords()
  {
    return str_word_count(str_replace('\r\n', " ", $this->text));
  }

  /**
   * @return int
   */
  public function numberOfStrings()
  {
    $strings = explode("\r\n", $this->text);
    return count($strings);
  }

  /**
   * @return string
   */
  public function longestWordKeeper()
  {
    $str = mb_strtolower($this->text);
    $str = str_replace('\r\n', " ", $str);
    $str = preg_replace("/\b\S\b/", "", $str);
    $str = preg_replace("/[^'\p{L} -]/u", "", $str);
    $match_words = preg_split('/\s+/', $str, -1, PREG_SPLIT_NO_EMPTY);
    foreach ($match_words as $key => $item) {
      $item = trim($item);
      if ($item == '' || mb_strlen($item) <= 1) {
        unset($match_words[$key]);
      }
    }

    array_push($match_words, $this->longestWordArray);
    $words_arr = array_unique($match_words);

    usort(
      $words_arr,
      function ($a, $b) {
        return (mb_strlen($b) <=> mb_strlen($a));
      }
    );

    $this->longestWordArray = $words_arr[0];

    return $words_arr[0];
  }

  /**
   * @return string
   */
  public function reverseWord()
  {
    $reversed = "";
    $tmp = "";
    for ($i = 0; $i < strlen($this->text); $i++) {
      if ($this->text[$i] == " ") {
        $reversed .= $tmp . " ";
        $tmp = "";
        continue;
      }
      $tmp = $this->text[$i] . $tmp;
    }
    $reversed .= $tmp;

    return $reversed;
  }

}

class FirstObserver implements Observer
{

  /**
   * @param SubjectInterface $observable
   *
   * @return void
   */
  public function handleEvent(SubjectInterface $observable)
  {
    echo '<u>' . get_called_class() . '</u>: <br>';
    echo 'Number of Words - ' . $observable->numberOfWords() . '<br>';
    echo 'Longest Word - ' . $observable->longestWordKeeper() . '<br>';
  }

}

class SecondObserver implements Observer
{

  /**
   * @param SubjectInterface $observable
   *
   * @return void
   */
  public function handleEvent(SubjectInterface $observable)
  {
    echo '<u>' . get_called_class() . '</u>: <br>';
    echo 'Number of Strings - ' . $observable->numberOfStrings() . '<br>';
    echo 'Reversed Word - ' . $observable->reverseWord() . '<br>';
  }

}


$scanner = new WordScanner();
$firstObserver = new FirstObserver();
$secondObserver = new SecondObserver();

$scanner->addObserver($firstObserver);
$scanner->addObserver($secondObserver);

$text = 'Just a simple text for test\r\nSecond line of text';
echo '<p><i>' . $text . '</i></p>';
$scanner->addText($text);

$text = 'Another text';
echo '<p><i>' . $text . '</i></p>';
$scanner->removeObserver($secondObserver);
$scanner->addText($text);

$text = 'Short text';
echo '<p><i>' . $text . '</i></p>';
$scanner->addText($text);

$text = '';
echo '<p><i>' . $text . '</i></p>';
$scanner->addText($text);
