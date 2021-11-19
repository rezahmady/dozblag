<div id="chart" style="height: 400px;background: white;
    border-radius: 5px;
    box-shadow: gainsboro 0 5px 15px!important;padding-top: 20px"></div>

<script >
    const chart = new Chartisan({
        el: '#chart',
        url: "@chart('monthly_chart')",
        hooks: new ChartisanHooks()
            .legend()
            // .colors(['#f9c659', '#f96dfb', '#6cc2ff', '#89d351'])
            .datasets('line'),
    });
</script>
