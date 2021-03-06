<?php

// Creates Words List Array
function createWordsListArray(string $text) {
  $text = mb_strtolower($text);
  $text = str_replace("\r\n", " ", $text);
  $text = preg_replace("/\b\S{1,3}\b/", "", $text);
  $text = preg_replace('/[^\p{L} -]/u', '', $text);
  $match_words = preg_split('/\s+/', $text, -1, PREG_SPLIT_NO_EMPTY);
  foreach ($match_words as $key => $item) {
    $item = trim($item);
    if ($item == '' || mb_strlen($item) <= 1) {
      unset($match_words[$key]);
    }
  }

  return $match_words;
}

// Creates Sentences List Array
function createSentencesListArray(string $text) {
	preg_match_all('#([\p{L}].*?[.!?])(?!\p{L})#ui', $text, $sentences);
	return $sentences[0];
}

// Creates Palindrome Words List Array
function createPalindromeWordsListArray(string $text) {
  $words_arr = createWordsListArray($text);
  $words_arr = array_unique($words_arr);

  $palindrome_words = [];
  foreach ($words_arr as $key => $value) {
    if ($value == reversedText($value)) {
      $palindrome_words[] = $value;
    }
  }

  return $palindrome_words;
}

// Number of characters
function numberOfCharacters(string $text) {
  $text = str_replace("\r\n", "", $text);
  return mb_strlen($text);
}

// Number of words
function numberOfWords(string $text) {
  $text = preg_replace('/\s+/', ' ', $text);
  $words = explode(" ", $text);

  return count($words);
}

// Number of sentences
function numberOfSentences(string $text) {
  return preg_match_all('#[^\s]([.!?])(?!\p{L})#ui', $text, $match);
}

// Frequency of characters & Distribution of characters as a percentage of total
function frequencyOfCharacters(string $text) {
  $text = mb_strtoupper($text);
  $unique = [];

  $lines_arr = preg_split('/\r\n/', $text);
  $num_newlines = count($lines_arr) - 1;
  if ($num_newlines) {
    $unique['paragraph'] = $num_newlines;
  }

  $text = str_replace("\r\n", "", $text);

  for ($i = 0; $i < mb_strlen($text); $i++) {
    $char = mb_substr($text, $i, 1);
    if (!array_key_exists($char, $unique)) {
      $unique[$char] = 0;
    }
    $unique[$char]++;
  }

  arsort($unique);
  $max_value = $unique ? max($unique) : null;

  $result = '<table>';
  $result .= '<tr><td>Character</td><td>Frequency</td><td>Percentage</td></tr>';
  foreach ($unique as $character => $number) {
    $percentage = round($number / $max_value * 100, 1);
    $character = str_replace(" ", 'space', $character);
    $result .= '<tr><td>' . $character . '</td><td>' . $number . '</td><td>' . $percentage . '</td></tr>';
  }
  $result .= '</table>';

  return $result;
}

// Average word length
function averageWordLength(string $text) {
  if (!$text) {
    return '';
  }

  $word_count = $word_length = 0;
  $words_arr = createWordsListArray($text);

  foreach ($words_arr as $word) {
    $word_count++;
    $word_length += mb_strlen($word);
  }

  return sprintf("The average word length is %.02f characters", $word_length / $word_count);
}

// Top X most used words
function mostUsedWords(string $text, int $max_count = 10) {
  $words_arr = createWordsListArray($text);
  $frequency = array_count_values($words_arr);
  arsort($frequency);
  $words_list = array_slice($frequency, 0, $max_count);

  return implode(', ', array_keys($words_list));
}

// Top X longest & shortest words
function mostLongestShortestWords(string $text, string $rule = null, int $max_count = 10) {
  $words_arr = createWordsListArray($text);
  $words_arr = array_unique($words_arr);

	if($rule == 'long') {
		usort($words_arr, function ($a, $b) { return (mb_strlen($b) <=> mb_strlen($a)); });
  } elseif ($rule == 'short') {
		usort($words_arr, function ($a, $b) { return (mb_strlen($a) <=> mb_strlen($b)); });
  } else {
		return '- wrong rule set -';
	}

  $words_list = array_slice($words_arr, 0, $max_count);

  return implode(', ', array_values($words_list));
}

// The average number of words in a sentence
function averageNumberOfWordsInSentence(string $text) {
	$word_count = $word_length = 0;
	$sentences_arr = createSentencesListArray($text);
	foreach ($sentences_arr as $sentence) {
		$word_count++;
    $word_length += numberOfWords($sentence);
	}

	if ($word_count < 1) {
		return '';
	}

  return sprintf("The average number of words in a sentence %.02f", $word_length / $word_count);
}

// Top X longest words & shortest sentences
function mostLongestSentences(string $text, string $rule = null, int $max_count = 10) {
	$sentences_arr = createSentencesListArray($text);

	if($rule == 'long') {
		usort($sentences_arr, function ($a, $b) { return (mb_strlen($b) <=> mb_strlen($a)); });
  } elseif ($rule == 'short') {
		usort($sentences_arr, function ($a, $b) { return (mb_strlen($a) <=> mb_strlen($b)); });
  } else {
		return '- wrong rule set -';
	}

  $sentences_list = array_slice($sentences_arr, 0, $max_count);

  return implode('<br><br>', array_values($sentences_list));
}

// Reversed text
function reversedText($text) {
  preg_match_all('/./us', $text, $array);
  return implode('', array_reverse($array[0]));
}

// The reversed text but the character order in words kept intact
function mirrorMultibyteString(string $text) {
  $array = preg_split('//u', $text, -1, PREG_SPLIT_NO_EMPTY);
  $array2 = implode('', $array);
  $array3 = explode(' ', $array2);

  return implode(' ', array_reverse($array3));
}

// Number of palindrome words
function numberOfPalindromeWords(string $text) {
  return count(createPalindromeWordsListArray($text));
}

// Most longest palindrome words
function mostLongestPalindromeWords(string $text, string $rule = 'long', int $max_count = 10) {
  $text = createPalindromeWordsListArray($text);
  $text = implode(' ', array_reverse($text));

  return mostLongestShortestWords($text, $rule, $max_count);
}

// Is the whole text a palindrome? (Without whitespaces and punctuation marks)
function isWholeTextPalindrome(string $text) {
  if ($text == reversedText($text)) {
    return 'Yes';
  } else {
    return 'No';
  }
}