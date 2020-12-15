<?php
$wordList = [
    "help",
    "rammstein",
    "james",
    "stackoverflow",
    "apollo",
    "lake",
    "stroopwafels",
    "frikandelbroodje",
];

$word = $wordList[array_rand($wordList)];
$correct = [];
$guessed = [];
$characters = str_split('abcdefghijklmnopqrstuvwxyz');
$nextMsg = "Welcome to hangman!";

function clearScr(){
    if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
        system('cls');
    }else {
        system('clear');
    }
}

function drawHangman($word, $correct, $nextMsg){
    print($nextMsg.PHP_EOL.PHP_EOL);

    $wordCharactersArray = str_split($word);
    for($i = 0; $i < count($wordCharactersArray); $i++){
        if(in_array($wordCharactersArray[$i], $correct)){
            print($wordCharactersArray[$i]);
        }else{
            print("_");
        }
    }
}

function input($input, $word, &$nextMsg, &$correct, &$guessed, &$characters){
    if(count(str_split($input))>1){
        if(strtolower($input)==strtolower($word)){
            clearScr();
            print("Congratulations, you guessed the word correctly!".PHP_EOL);
            die();
        }else{
            return $nextMsg="Word guess incorrect";
        }
    }else{
        $input = strtolower($input);
        if(($key = array_search($input, $correct)) !== false){
            return $nextMsg="You already correctly guessed this letter";
        }
        if(($key = array_search($input, $guessed)) !== false){
            return $nextMsg="You already incorrectly guessed this letter";
        }
        if(($key = array_search($input, $characters)) !== false){
            unset($characters[$key]);
            $wordCharactersArray = str_split($word);
            array_push($guessed, $input);
            if(in_array($input, $wordCharactersArray)){
                array_push($correct, $input);
                return $nextMsg="Correct guess!";
            }else{
                return $nextMsg="Incorrect guess, try again";
            }

        }else{
            return $nextMsg="You cannot guess this letter, try again";
        }
    }
}

while(true){
    clearScr();
    drawHangman($word, $correct, $nextMsg);

    print(PHP_EOL.PHP_EOL."Guess a letter or guess the whole word: ");
    $handle = fopen ("php://stdin","r");
    $line = trim(fgets($handle));

    input($line, $word, $nextMsg, $correct, $guessed, $characters);
}
?>