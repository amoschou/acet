<?php

function gq_insert($table,$keys,$values)
{
  return "INSERT INTO {$table} ({$keys}) VALUES ({$values})";
}
