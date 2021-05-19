<?php

# *** Adapter ***
# Create an implementation for the IntegerStackInterface.
# Create an adapter for the IntegerStackInterface implementation and the ASCIIStackInterface
# IntegerStackInterface:
# - public function push(int $integer): void;
# - public function pop(): int
# ASCIIStackInterface:
# - public function push(string $char): void;
# - public function pop(): ?string;

interface IntegerStackInterface
{
  public function push(int $integer): void;
  public function pop(): int;
}

interface ASCIIStackInterface
{
  public function push(string $char): void;
  public function pop(): ?string;
}

class IntegerStack implements IntegerStackInterface
{
  private $stack;

  public function push(int $integer): void {
    $this->stack = $integer;
  }

  public function pop(): int {
    return (int) $this->stack;
  }

}

class Adapter implements ASCIIStackInterface
{
  private $adaptee;

  public function __construct(IntegerStackInterface $adaptee ) {
    $this->adaptee = $adaptee;
  }

  public function push(string $char): void {
    $this->adaptee->push((int) ord($char));
  }

  public function pop(): ?string {
    return (string) $this->adaptee->pop();
  }
}

$adaptee = new IntegerStack();
$adaptee->push(97);
echo $adaptee->pop();

echo '<br>';

$adapter = new Adapter($adaptee);
$adapter->push('a');
echo $adapter->pop();
