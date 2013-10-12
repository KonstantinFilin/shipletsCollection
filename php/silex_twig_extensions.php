<?php 


$app["twig"]->addFilter(
    new Twig_SimpleFilter('n2', function ($string) {
        return strlen($string) == 2 ? $string : "0" . $string;
    })
);

$app["twig"]->addFunction(
    new Twig_SimpleFunction('d', function ($string, $formatIn="Y-m-d H:i:s") {
        $ret = " ";

        $emptyVals = getEmptyDtVals();

        if($string && !empty($string) && !in_array($string, $emptyVals)) {
            $ret = \KsUtils\Dt::convert($string, $formatIn, "d.m.Y");
        }

        return $ret;
    })
);

$app["twig"]->addFunction(
    new Twig_SimpleFunction('dt', function ($string) {
        $ret = " ";

        $emptyVals = getEmptyDtVals();

        if($string && !empty($string) && !in_array($string, $emptyVals)) {
            $ret = \KsUtils\Dt::convert($string, "Y-m-d H:i:s", "d.m.Y H:i");
        }

        return $ret;
    })
);

$app["twig"]->addFunction(
    new Twig_SimpleFunction('t', function ($string) {
        $ret = " ";

        if($string && !empty($string) && $string != "0000-00-00 00:00:00") {
            $ret = \KsUtils\Dt::convert($string, "Y-m-d H:i:s", "H:i");
        }

        return $ret;
    })
);

$app["twig"]->addFunction(
    new Twig_SimpleFunction('num', function ($num, $precision=0, $sepDec=",", $sepThous=" ") {
        return number_format($num, $precision, $sepDec, $sepThous);
    })
);

$pluralFunction = new Twig_SimpleFunction("plural", function($num, $forms) {
    $retForm = "";

    $numAbs = abs($num);
    $rest10 = $numAbs%10;
    $rest100 = $numAbs%100;

    if($rest10 == 1 && $rest100 != 11) {
        $retForm = $forms[0];
    } elseif($rest10 >= 2 && $rest10 <= 4 && ($rest100 < 10 || $rest100 >= 20)) {
        $retForm = $forms[2];
    } else {
        $retForm = $forms[1];
    }

    return $num . " " . $retForm;
});

$app["twig"]->addFunction($pluralFunction);

function getEmptyDtVals()
{
    return array(
        "0000-00-00 00:00:00",
        "0000-00-00 00:00",
        "0000-00-00",
        "00:00:00",
        "00:00"
    );
}
