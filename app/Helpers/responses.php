<?php

function success()
{
    return response()->json(['success' => true], 200);
}

function fail()
{
    return response()->json(['success' => false], 200);
}