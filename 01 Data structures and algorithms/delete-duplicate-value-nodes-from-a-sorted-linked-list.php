<?php

# Delete duplicate-value nodes from a sorted linked list
# https://www.hackerrank.com/challenges/delete-duplicate-value-nodes-from-a-sorted-linked-list/problem

// Creates Singly Linked List
function createSinglyLinkedListNode($arr) {
  if (!$arr) {
    return NULL;
  }
  return (object) [
    'data' => array_shift($arr),
    'next' => createSinglyLinkedListNode($arr),
  ];
}

// Removes Duplicated Nodes
function removeDuplicates($llist) {
  $node = $llist;
  while ($node->next) {
    // if the value of next node is the same as current then skip next node
    if ($node->data == $node->next->data) {
      $node->next = $node->next->next;
    } else {
      $node = $node->next;
    }
  }

  return $llist;
}

$llist = createSinglyLinkedListNode([1, 2, 2, 3, 4]); // Creates Singly Linked List
print_r($llist); // Displays Singly Linked List with Duplicated Nodes
print_r(removeDuplicates($llist)); // Displays Singly Linked List without Duplicated Nodes