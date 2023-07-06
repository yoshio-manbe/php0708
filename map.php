<?php require 'header.php'; ?>

<?php

// funcs.phpを読み込む
require_once('funcs.php');

//1.  DB接続します
try {
    $pdo = new PDO('mysql:dbname=gs_db2;charset=utf8;host=localhost','root','');
} catch (PDOException $e) {
    exit('DBConnectError'.$e->getMessage());
}

$stmt = $pdo->prepare("SELECT * FROM gs_an_table2 ");
$status = $stmt->execute();

?>
<div id="myMap" style="width:800px; height:600px; margin: 0 auto;"></div>

<div id="route">
    <select name="スタート" id="one">
        <?php
        $stmt = $pdo->prepare("SELECT * FROM gs_an_table2");
        $status = $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $id = $row['id'];
            $place = $row['place'];
            $address = $row['address'];
            $content = $row['content'];
            $category = $row['category'];
            echo "<option value='$place' data-address='$address'>$place - $address ($category)</option>";
            echo "<script>var addressValue = '" . $address . "'; var placeValue = '" . $place . "';</script>";
        }
        ?>
    </select>
    <p>⬇️</p>
    <select name="スタート" id="two">
        <?php
        $stmt->execute(); // 結果セットをリセットするために再度実行する
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $id2 = $row['id'];
            $place2 = $row['place'];
            $address2 = $row['address'];
            $content2 = $row['content'];
            $category2 = $row['category'];
            echo "<option value='$place2' data-address='$address2'>$place2 - $address2 ($category2)</option>";
            echo "<script>var addressValue2 = '" . $address2 . "'; var placeValue2 = '" . $place2 . "';</script>";
        }
        ?>
    </select>
    <p>⬇️</p>
    <select name="スタート" id="three">
        <?php
        $stmt->execute(); // 結果セットをリセットするために再度実行する
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $id3 = $row['id'];
            $place3 = $row['place'];
            $address3 = $row['address'];
            $content3 = $row['content'];
            $category3 = $row['category'];
            echo "<option value='$place3' data-address='$address3'>$place3 - $address3 ($category3)</option>";
            echo "<script>var addressValue3 = '" . $address3 . "'; var placeValue3 = '" . $place3 . "';</script>";
        }
        ?>
    </select>


        <div class="button">
            <button id="calculate">検索</button>
            <button id="clear">クリア</button>
        </div>


</div>

<div id="printoutPanel"></div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type='text/javascript' src='https://www.bing.com/api/maps/mapcontrol?key=####&callback=loadMapScenario' async defer></script>
<script src="./js/BmapQuery.js"></script>
<script src="https://cdn.geolonia.com/community-geocoder.js"></script>
<script>
    function loadMapScenario() {
    var map = new Microsoft.Maps.Map(document.getElementById('myMap'), {
        /* No need to set credentials if already passed in URL */
        center: new Microsoft.Maps.Location(43.07166, 141.31392),
        zoom: 12
    });
    Microsoft.Maps.loadModule('Microsoft.Maps.Directions', function () {
        var directionsManager = new Microsoft.Maps.Directions.DirectionsManager(map);
        directionsManager.setRenderOptions({ itineraryContainer: document.getElementById('printoutPanel') });
        directionsManager.showInputPanel('directionsInputContainer');
    });

    Microsoft.Maps.loadModule('Microsoft.Maps.Search', function () {
        $(document).ready(function(){
            var selectOne = document.getElementById('one');
            var selectTwo = document.getElementById('two');
            var selectThree = document.getElementById('three');

            var oneplace, twoplace, threeplace;
            var oneaddress, twoaddress, threeaddress;
            var onelatitude, twolatitude, threelatitude;
            var onelongitude, twolongitude, threelongitude;


            $("#one").change(function() {
                var selectedOption = $(this).val();
                var selectedAddress = $("option:selected", this).data("address");

                oneplace =selectedOption
                        
                if (selectedOption) {
                    getLatLng(selectedAddress, function(result) {
                        console.log("緯度: ", result.lat);
                        console.log("経度: ", result.lng);
                        onelatitude = result.lat;
                        onelongitude = result.lng;
                    });
                }
            });

            $("#two").change(function() {
                var selectedOption2 = $(this).val();
                var selectedAddress2 = $("option:selected", this).data("address");

                twoplace =selectedOption2
                        
                if (selectedOption2) {
                    getLatLng(selectedAddress2, function(result) {
                        console.log("緯度: ", result.lat);
                        console.log("経度: ", result.lng);
                        twolatitude = result.lat;
                        twolongitude = result.lng;
                    });
                }
            });

            $("#three").change(function() {
                var selectedOption3 = $(this).val();
                var selectedAddress3 = $("option:selected", this).data("address");

                threeplace =selectedOption3
                        
                if (selectedOption3) {
                    getLatLng(selectedAddress3, function(result) {
                        console.log("緯度: ", result.lat);
                        console.log("経度: ", result.lng);
                        threelatitude = result.lat;
                        threelongitude = result.lng;
                    });
                }
            });

        $("#calculate").click(function() {
            console.log(oneplace, twoplace, threeplace);

    if (oneplace && twoplace && threeplace) {
                var directionsManager = new Microsoft.Maps.Directions.DirectionsManager(map);
                directionsManager.setRequestOptions({ routeMode: Microsoft.Maps.Directions.RouteMode.driving }); // ルートのモードを指定する

                directionsManager.clearAll();

                var oneWaypoint = new Microsoft.Maps.Directions.Waypoint({ address: oneplace, location: new Microsoft.Maps.Location(onelatitude, onelongitude) });
                directionsManager.addWaypoint(oneWaypoint);

                var twoWaypoint = new Microsoft.Maps.Directions.Waypoint({ address: threeplace, location: new Microsoft.Maps.Location(threelatitude, threelongitude) });
                directionsManager.addWaypoint(twoWaypoint);

                directionsManager.addWaypoint(new Microsoft.Maps.Directions.Waypoint({ address: twoplace, location: new Microsoft.Maps.Location(twolatitude, twolongitude) }), 1);

                directionsManager.setRenderOptions({ itineraryContainer: document.getElementById('printoutPanel') });
                directionsManager.calculateDirections();
            }
    
            
});


        $("#clear").click(function(){
            location.reload();
        });
    });
    });
}
</script>

<style>
    #printoutPanel{
    position: relative;
    margin-left: 420px;
    top: 150px;
    text-align: center;
}
#route{
    position: relative;
    margin: 0 auto;
    text-align: center;
    top: 100px;
    display: flex;
    flex-direction: column;
}
#route select{
    width: 200px;
    margin: 0 auto;
    font-size: 20px;
}
#route button{
    width: 100px;
    margin: 25px auto;
    font-size: 20px;
}
</style>