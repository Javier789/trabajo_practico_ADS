<?php
/* @var $notas */

?>

<h1>Mis notas</h1>

<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>
<div ng-app="myApp" ng-controller="myCtrl">

<table class="table table-bordered">

  <tr>

    <th>Descripcion</th>

    <th>Nota</th>

  </tr>

  <tr ng-repeat="n in notas">

    <td>{{n.descripcion}}</td>

    <td>{{n.nota}}</td>

  </tr>

</table>
    <?php
    foreach ($notas as $item) {
        echo var_dump($item['data']);
    }
    ?>
</div>
<script>
    var app = angular.module('myApp', []);
    app.controller('myCtrl', function ($scope) {
        $scope.notas = [{descripcion: "Primer Parcial", nota: 9}];
    });
</script>