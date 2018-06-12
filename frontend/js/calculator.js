(function () {


    var $http = {
        makeHttpRequest:function () {
            try {return new XMLHttpRequest();}
            catch (error) {}
            try {return new ActiveXObject("Msxml2.XMLHTTP");}
            catch (error) {}
            try {return new ActiveXObject("Microsoft.XMLHTTP");}
            catch (error) {}

            throw new Error("Could not create HTTP request object.");
        },
        post:function (url, params) {

            var request = this.makeHttpRequest();
            var data = "data="+JSON.stringify(params);
            request.open("POST",url,true);
            request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            request.send(data);
            request.onreadystatechange = function() {
                if (request.readyState === 4 && request.status===200)
                {
                    var data = JSON.parse(request.response);
                    var headerRow = document.createElement('tr');
                    var valueRow = document.createElement('tr');
                    var baseRow = document.createElement('tr');
                    var commissionRow = document.createElement('tr');
                    var taxRow = document.createElement('tr');
                    var totalRow = document.createElement('tr');
                    var valueheader = document.createElement('td');
                    valueheader.innerHTML="Value";
                    valueRow.appendChild(valueheader);
                    var baseheader = document.createElement('td');
                    baseheader.innerHTML = "Base premium (11%)";
                    baseRow.appendChild(baseheader);
                    var btotal = document.createElement('td');
                    btotal.innerHTML = data.rows.reduce(function (a, b) {
                        return a.base + b.base;
                    }).toFixed(2);
                    baseRow.appendChild(btotal);
                    var commissionheader = document.createElement('td');
                    commissionheader.innerHTML = "Commission (17%)";
                    commissionRow.appendChild(commissionheader);
                    var ctotal = document.createElement('td');
                    ctotal.innerHTML = data.rows.reduce(function (a, b) {
                        return a.commission + b.commission;
                    }).toFixed(2);
                    commissionRow.appendChild(ctotal);
                    var taxheader = document.createElement('td');
                    taxheader.innerHTML = "Tax "+params.data.tax;
                    taxRow.appendChild(taxheader);
                    var xtotal = document.createElement('td');
                    xtotal.innerHTML = data.rows.reduce(function (a, b) {
                        return a.tax + b.tax;
                    }).toFixed(2);
                    taxRow.appendChild(xtotal);
                    var totalheader = document.createElement('td');
                    totalheader.innerHTML="<b> Total Cost</b>";
                    totalRow.appendChild(totalheader);
                    var stotal = document.createElement('td');
                    stotal.innerHTML = "<strong>"+data.totalCost.toFixed(2)+"</strong>";
                    totalRow.appendChild(stotal);
                    var blank = document.createElement('th');
                    var policyHeader = document.createElement('th');
                    policyHeader.innerHTML="<strong>Policy</strong>";
                    headerRow.appendChild(blank);
                    headerRow.appendChild(policyHeader);
                    var value = document.createElement('td');
                    value.innerHTML = data.value;
                    valueRow.appendChild(value);
                    for (var i = 0; i<data.instalment;i++) {

                        var header = document.createElement('th');
                        header.innerHTML="<strong>"+(i+1)+" installment</strong>";
                        headerRow.appendChild(header);
                        var base = document.createElement('td');
                        base.innerHTML = data.rows[i].base.toFixed(2);
                        baseRow.appendChild(base);

                        var commission = document.createElement('td');
                        commission.innerHTML = data.rows[i].commission.toFixed(2);
                        commissionRow.appendChild(commission);

                        var tax = document.createElement('td');
                        tax.innerHTML = data.rows[i].tax.toFixed(2);
                        taxRow.appendChild(tax);

                        var total = document.createElement('td');
                        total.innerHTML = data.rows[i].total.toFixed(2);
                        totalRow.appendChild(total);

                    }
                    var table = document.getElementById('tbody');
                    table.appendChild(headerRow);
                    table.appendChild(valueRow);
                    table.appendChild(baseRow);
                    table.appendChild(commissionRow);
                    table.appendChild(taxRow);
                    table.appendChild(totalRow);
                    table.parentElement.style.display = "table";
                }
            };

        }
    };

    var url= "http://localhost/vanilla/public/index.php/calculate";
    var get= "http://localhost/vanilla/public/index.php/welcome";

    function Calculate() {
        var value = document.getElementById('value').value;
        var tax = document.getElementById('tax').value;
        var instalment = document.getElementById('instalment').value;
        $http.post(url,{
            data:{
                value: value,
                tax: tax,
                instalment: instalment
            }
        });

    }


    document.onreadystatechange = function () {
        if (document.readyState === "complete") {
              document.getElementById('calculate').addEventListener('click',function (ev) { Calculate(); })
        }
    }





})()