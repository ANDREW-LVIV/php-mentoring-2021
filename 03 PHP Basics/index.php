<?php

header('Content-Type: text/html; charset=utf-8');
include_once "fnc.php";

$text = $_POST['text'] ?? '';
$time = date("Y-m-d H:i:s");

$analyze_results = [
  [
    'title' => 'Number of characters:',
    'result' => numberOfCharacters($text),
  ],
  [
    'title' => 'Number of words',
    'result' => numberOfWords($text),
  ],
  [
    'title' => 'Number of sentences',
    'result' => numberOfSentences($text),
  ],
  [
    'title' => 'Frequency of characters / Distribution of characters as a percentage of total',
    'result' => frequencyOfCharacters($text, 'number'),
  ],
  [
    'title' => 'Average word length',
    'result' => averageWordLength($text),
  ],
  [
    'title' => 'The average number of words in a sentence',
    'result' => averageNumberOfWordsInSentence($text),
  ],
  [
    'title' => 'Top 10 most used words',
    'result' => mostUsedWords($text, 10),
  ],
  [
    'title' => 'Top 10 longest words',
    'result' => mostLongestShortestWords($text, 'long', 10),
  ],
  [
    'title' => 'Top 10 shortest words',
    'result' => mostLongestShortestWords($text, 'short', 10),
  ],
  [
    'title' => 'Top 10 longest sentences',
    'result' => mostLongestSentences($text, 'long', 10),
  ],
  [
    'title' => 'Top 10 shortest sentences',
    'result' => mostLongestSentences($text, 'short', 10),
  ],
  [
    'title' => 'Number of palindrome words',
    'result' => numberOfPalindromeWords($text),
  ],
  [
    'title' => 'Top 10 longest palindrome words',
    'result' => mostLongestPalindromeWords($text, 'long', 10),
  ],
  [
    'title' => 'Is the whole text a palindrome? (Without whitespaces and punctuation marks)',
    'result' => isWholeTextPalindrome($text),
  ],
  [
    'title' => 'The reversed text',
    'result' => reversedText($text),
  ],
  [
    'title' => 'The reversed text but the character order in words kept intact',
    'result' => mirrorMultibyteString($text),
  ],
  [
    'title' => 'The time it took to process the text in ms',
    'result' => (microtime(TRUE) - $_SERVER['REQUEST_TIME_FLOAT']) * 1000 ?: 'not calculated because of 0ms',
  ],
];

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Text Analyzer</title>
  <link rel="stylesheet" type="text/css" href="style.css"/>
</head>

<body>

  <div class="header">
    <h2>Text Analyzer</h2>
  </div>

  <div class="main">
    <form action="" method="POST">
      <textarea type="text" name="text" rows="8"
        placeholder="Enter text to analyze"><?= htmlspecialchars($text); ?></textarea><br/>
        <input type="submit" value="analyze text">
      </form>
    </div>

    <?php if ($text): ?>
      <div class="results">
        <h3>Statistical information</h3>

        <?php foreach($analyze_results as $result): ?>
          <div class="result_item">
            <div class="result_title"><?= $result['title']; ?></div>
            <div class="result_data"><?= $result['result'] ?: " - no results -" ?></div>
          </div>
        <?php endforeach?>
        <div class="report">
          Report was generated: <?= $time; ?>
        </div>
      </div>
    <?php endif; ?>

  </body>
</html>

