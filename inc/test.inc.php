<button class="btn btn-secondary" onclick="plus()">PLUS</button><br>
<button class="btn btn-secondary" onclick="min()">MIN</button><br>
<h1 id="counter"></h1>

<script>
    var output = 0;
    document.getElementById("counter").innerHTML = output;

    function plus() {

        output = output + 1;
        document.getElementById("counter").innerHTML = output;

        return output;
    }

    function min() {

        output = output - 1;
        if(output <= -1){
            output = 0;
        }

        document.getElementById("counter").innerHTML = output;
        return output;
    }

</script>