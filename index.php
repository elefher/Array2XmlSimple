<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        include './Array2XmlSimple.php';
        //error_reporting(E_ALL);
        //ini_set('display_errors', 'On');
        
        $packageId = array(
            "ClientId" => array(
                "@attributes" => array(
                    "idOwner" => "owner"
                ),
                array("idValue" => array(
                        "@attributes" => array(
                            "name" => "some name"
                        ),
                        "@value" => "0001"
                    )
                )
            ),
            "PackageId" => array(
                "@attributes" => array(
                    "idOwner" => "package owner"
                ),
                array("idValue" => array(
                        "@attributes" => array(
                            "name" => "Instr"
                        ),
                        "@value" => "this is a value"
                    )
                ),
                array("idValue" => array(
                        "@attributes" => array(
                            "name" => "something else"
                        ),
                        "@value" => "second val"
                    )
                )
            )
        );
        Array2XmlSimple::buildXml("AssessmentOrderRequest", $packageId);
        print_r(htmlentities(Array2XmlSimple::xmlExport()));
        ?>
    </body>
</html>
