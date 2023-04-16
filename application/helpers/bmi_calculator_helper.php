<?php

/*

Underweight = <18.5
Normal weight = 18.5–24.9
Overweight = 25–29.9
Obesity = BMI of 30 or greater

*/

function bmi_calculator($data) {

    // weight pounds and height feet
    $bmi = (floatval($data['weight']) / ((floatval($data['heightfeet'])*12+floatval($data['heightinches'])) ** 2)) * 703;

    // weight kg and height cm
    // $bmi = floatval($data['weight']) / (floatval($data['height']) ** 2);

    return $bmi; 
}

function bmi_calculator_status($bmi) {

    return (floatval($bmi) >= 30) ? 6: 4; 
}
