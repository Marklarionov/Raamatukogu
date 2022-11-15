<?php
require_once ('connect.php');
global $yhendus;
if (isset($_REQUEST['lisamisvorm']) && !empty($_REQUEST["nimi"])){
    $paring=$yhendus->prepare(
        "INSERT INTO raamatud2(nimi,aasta,autor,varv) VALUES (?,?,?,?)"
    );
    $paring->bind_param("ssss",$_REQUEST["nimi"], $_REQUEST["aasta"], $_REQUEST["autor"], $_REQUEST["varv"]);
    //"s" - string ,$_REQUEST["nimi"] - tekstkasti nimega nimi pördumine
    //sdi, s-string, d-double, i-integer
    $paring->execute();
    //aadressi ribas eemaldatakse php käsk
    header("Location: $_SERVER[PHP_SELF]");
}
if (isset($_REQUEST['kustuta'])){
    $paring=$yhendus->prepare("DElETE FROM raamatud2 WHERE id=?");
    $paring->bind_param("i",$_REQUEST['kustuta']);
    $paring->execute();
}
?>
<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <title>Raamatukogu</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<h1>Raamatukogu</h1>
<div id="meny">
<ul>
    <?php
    global $yhendus;
    $paring=$yhendus->prepare("SELECT id,nimi from raamatud2");
    $paring->bind_result($id,$nimi);
    $paring->execute();
    while ($paring->fetch()) {
        echo "<a href='?id=$id'> $nimi <br></a>";
    }
    echo "</ul>";
    echo "<a href='?lisaraamat=jah'>Lisa Raamat</a>";
    ?>
</div>
<div id="sisu">
    <?php
    if (isset($_REQUEST["id"])){
        $paring=$yhendus->prepare("SELECT autor,aasta,varv,nimi FROM raamatud2 where id=?");
        $paring->bind_param("i",$_REQUEST['id']);
        //?küsimärki asemel aadressiribalt tuleb id
        $paring->bind_result($autor,$aasta,$varv,$nimi);
        $paring->execute();
        if ($paring->fetch()){
            echo "<div id=andmed><strong>".htmlspecialchars($nimi)."</strong>, ";
            echo  htmlspecialchars($aasta)." aastat";
            echo "<br>Autor - ".htmlspecialchars($autor);
            echo "<br>    varv - ". htmlspecialchars($varv);
            echo "<br><a href='?kustuta=$id'> Kustuta</a>";

            echo "</div>";
        }
    }

    if (isset($_REQUEST["lisaraamat"])){
    ?>
    <h2>Uue looma lisamine</h2>
    <form name="uusraamat" method="post" action="?">
        <input type="hidden" name="lisamisvorm" value="jah">
        <input type="text" id="name" name="nimi" placeholder="raamatu nimi">
        <br>
        <input type="text" name="aasta" max="30" placeholder="raamatu aasta">
        <br>
        <input type="text" name="autor" max="30" placeholder="raamatu autor">
        <br>
        <input type="text" name="varv" placeholder="varv">
        <input type="submit" value="OK">
    </form>
        <?php
    }
    else {
        echo "<h3>Siia tuleb raamatu info</h3>";
    }
    $yhendus->close();
    ?>

</body>
</html>