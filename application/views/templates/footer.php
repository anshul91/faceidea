<!--<div class="topnav-dropdown-footer">
    <a href="https://www.gadgetprogrammers.online">Powered By : Gadgetprogrammers.online</a>
</div>-->
</div>
</div>			
</div>
</div>	
<div class="sidebar-overlay" data-reff="#sidebar"></div>
<script type="text/javascript" src="<?php echo JS_COMMON_URL; ?>jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="<?php echo JS_COMMON_URL; ?>bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo JS_COMMON_URL; ?>jquery.slimscroll.js"></script>
<script type="text/javascript" src="<?php echo JS_COMMON_URL;?>jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo JS_COMMON_URL;?>dataTables.bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo JS_COMMON_URL; ?>plugins/morris/morris.min.js"></script>
<script type="text/javascript" src="<?php echo JS_COMMON_URL; ?>plugins/raphael/raphael-min.js"></script>

		<script type="text/javascript" src="<?php echo JS_COMMON_URL; ?>select2.min.js"></script>
<script type="text/javascript" src="<?php echo JS_COMMON_URL; ?>moment.min.js"></script>
<script type="text/javascript" src="<?php echo JS_COMMON_URL; ?>bootstrap-datetimepicker.min.js"></script>
<script type="text/javascript" src="<?php echo JS_COMMON_URL; ?>/app.js"></script>

<script>
    var data = [
        {y: '2014', a: 50, b: 90},
        {y: '2015', a: 65, b: 75},
        {y: '2016', a: 50, b: 50},
        {y: '2017', a: 75, b: 60},
        {y: '2018', a: 80, b: 65},
        {y: '2019', a: 90, b: 70},
        {y: '2020', a: 100, b: 75},
        {y: '2021', a: 115, b: 75},
        {y: '2022', a: 120, b: 85},
        {y: '2023', a: 145, b: 85},
        {y: '2024', a: 160, b: 95}
    ],
            config = {
                data: data,
                xkey: 'y',
                ykeys: ['a', 'b'],
                labels: ['Total Income', 'Total Outcome'],
                fillOpacity: 0.6,
                hideHover: 'auto',
                behaveLikeLine: true,
                resize: true,
                pointFillColors: ['#ffffff'],
                pointStrokeColors: ['black'],
                gridLineColor: '#eef0f2',
                lineColors: ['gray', '#00c5fb']
            };
    config.element = 'area-chart';
    Morris.Area(config);
    config.element = 'line-chart';
    Morris.Line(config);
    config.element = 'bar-chart';
    Morris.Bar(config);
    config.element = 'stacked';
    config.stacked = true;
    Morris.Bar(config);
    Morris.Donut({
        element: 'pie-chart',
        data: [
            {label: "Employees", value: 30},
            {label: "Clients", value: 15},
            {label: "Projects", value: 45},
            {label: "Tasks", value: 10}
        ]
    });
</script>
</body>