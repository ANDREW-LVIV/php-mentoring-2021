<?php

# Tree: Height of a Binary Tree
# https://www.hackerrank.com/challenges/tree-height-of-a-binary-tree/problem

// Creates Tree Branches
class Node {
  private $left;
  private $right;

  public function __construct(Node $left = NULL, Node $right = NULL) {
    $this->left = $left;
    $this->right = $right;
  }

  public function __get($attr) {
    return $this->{$attr};
  }

}

// Creates Tree structure
//       3
//    2     5
//  1     4   6
//              7
$node = new Node( //3
  new Node( //2
    new Node() //1
  ),
  new Node( //5
    new Node(), //4
    new Node( //6
      new Node() //7
    )
  )
);

// Calculates max Tree Height
function maxHeight($node) {
  if (!$node) {
    return -1;
  }
  $leftDepth = 1 + maxHeight($node->left);
  $rightDepth = 1 + maxHeight($node->right);

  return $leftDepth > $rightDepth ? $leftDepth : $rightDepth;
}

print_r(maxHeight($node)); // Outputs max Tree Height