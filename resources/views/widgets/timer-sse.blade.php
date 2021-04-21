

<div id="result">
    <!--Server response will be inserted here-->
</div>

<script>
    if ( typeof ( EventSource ) !== " undefined " ) {
        // SSE پشتیانی مرورگر از
        // کدهای مورد نظر
        console.log('your browser support SSE')
        window.onload = function(){
            var source = new EventSource("http://gariin.test/admin/aa");
            source.onmessage = function(event){
                console.log(event.data)
                document.getElementById("result").innerHTML = "time server: " + event.data + "<br>";
            };
        };
    }
    else  {
        // SSE  عدم پشتیبانی مرورگر                 از                 
        // کدهای مورد نظر
        console.log('your browser dont support SSE')
    } 
</script>