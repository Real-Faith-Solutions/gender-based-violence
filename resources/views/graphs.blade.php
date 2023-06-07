<canvas id="myChart" style="width:100%;max-width:700px;"></canvas>

<script type="text/javascript">
    <?php
        include 'db.php';

        $xValues = ''; $yValues = '';

        $result = $con->query("SELECT `gender`, `age`, count(gender) as `counts` FROM persons WHERE `gender` = 'Male' GROUP BY `gender`, `age` ORDER BY `age`;");
        while ($row = mysqli_fetch_assoc($result)) {
            $tcolor = '';

            $xValues .= '"'.$row['gender'].' ('.$row['age'].')", ';
            $yValues .= $row['counts'].', ';
        }
    ?>

    var xValues = [<?php echo $xValues; ?>];
    var yValues = [<?php echo $yValues; ?>];
    var barColors = ["crimson", "yellowgreen","purple","dodgerblue","orange", "pink", "violet", "brown"];

    new Chart("myChart", {
        type: "bar",
        data: {
        labels: xValues,
        datasets: [{
            backgroundColor: barColors,
            data: yValues
        }]
        },
        options: {
        title: {
            display: true,
            text: "Graph for Male Counts"
        },
        legend: {
            display: false
        }
        }
    });
</script>
