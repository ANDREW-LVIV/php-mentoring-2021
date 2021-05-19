<?php

# *** Strategy ***
# Create an EmployeeCollection class that holds multiple employees and can be ordered in multiple ways.
# Required orderings:
# - Department name ascending and descending
# - Name ascending and descending
# - Salary ascending and descending

$data = [
  ['department' => 'Physics', 'name' => 'A-user', 'salary' => 380],
  ['department' => 'Biology', 'name' => 'C-user', 'salary' => 470],
  ['department' => 'Chemistry', 'name' => 'E-user', 'salary' => 400],
  ['department' => 'Geography', 'name' => 'F-user', 'salary' => 430],
  ['department' => 'Biology', 'name' => 'B-user', 'salary' => 250],
  ['department' => 'Physics', 'name' => 'G-user', 'salary' => 400],
  ['department' => 'Physics', 'name' => 'D-user', 'salary' => 500],
];

interface SortStrategyInterface
{
  public function doSort(array $array, string $orderBy): array;
}

class EmployeeCollection {
  private $strategy;

  public function __construct(SortStrategyInterface $strategy) {
    $this->strategy = $strategy;
  }

  public function setSortStrategy(SortStrategyInterface $strategy) {
    $this->strategy = $strategy;
  }

  public function setOrder(array $array, string $orderBy): string
  {
    $items = $this->strategy->doSort($array, $orderBy);

    $result = '<table>';
    $result .= '<tr><td>Department</td><td>Name</td><td>Salary</td></tr>';
    foreach ($items as $item) {
      $result .= '<tr><td>' . $item['department'] . '</td><td>' . $item['name'] . '</td><td>' . $item['salary'] . '</td></tr>';
    }
    $result .= '</table>';

    return $result;
  }

}


class SortAscendStrategy implements SortStrategyInterface
{
  public function doSort(array $array, string $orderBy): array {
    $columns = array_column($array, $orderBy);
    array_multisort($columns, SORT_ASC, $array);

    return $array;
  }
}

class SortDescendStrategy implements SortStrategyInterface
{
  public function doSort(array $array, string $orderBy): array {
    $columns = array_column($array, $orderBy);
    array_multisort($columns, SORT_DESC, $array);

    return $array;
  }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Strategy pattern</title>
</head>
<body>

<?php

$context = new EmployeeCollection(new SortAscendStrategy());
echo "<h3>Normal sorting by:</h3>";
echo "<p><b>NAME</b>" . $context->setOrder($data, 'name') . "</p>";
echo "<p><b>DEPARTMENT</b>" . $context->setOrder($data, 'department') . "</p>";
echo "<p><b>SALARY</b>" . $context->setOrder($data, 'salary') . "</p>";

echo "<br>";

$context->setSortStrategy(new SortDescendStrategy());
echo "<h3>Reverse sorting by:</h3>";
echo "<p><b>NAME</b>" . $context->setOrder($data, 'name') . "</p>";
echo "<p><b>DEPARTMENT</b>" . $context->setOrder($data, 'department') . "</p>";
echo "<p><b>SALARY</b>" . $context->setOrder($data, 'salary') . "</p>";

?>

</body>
</html>

