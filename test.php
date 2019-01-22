<?php

const FILE_PATH = 'test.txt';

if (!file_exists(FILE_PATH)) {
    throw new ErrorException("error");
}

$file = fopen(FILE_PATH, "r+");
$sum = 0;

if (flock($file, LOCK_EX | LOCK_NB)) {
    while ($line = fgets($file)) {
        $sum += (int)$line;
    }
    fwrite($file, "\nSum = ".$sum."\n");
    sleep(120);
    flock($file, LOCK_UN);
    fclose($file);
} else {
    sleep(5);
    if (!flock($file, LOCK_EX | LOCK_NB)) {
        throw new ErrorException("file was locked");
    }

}