function search(){
    //declare variables

    var input, filter, table, tr, td, i, textValue;

    input = document.getElementById("myInput");

    filter = input.value.toUpperCase();

    table = document.getElementById("myTable");

    tr = table.getElementsByTagName("tr");

/* Loop through all table rows and hide those don't match the search input*/
    for(i =0; i< tr.length; i++)
    {
        td = tr[i].getElementsByTagName("td")[1];
        if(td)
        {
            textValue = td.textContent || td.innerText;

            if(textValue.toLocaleUpperCase().indexOf(filter)>-1)
            {
                tr[i].style.display=""
            }
            else{
                tr[i].style.display="none";
            }
        }
    }
}

const updated_counter = document.querySelector(".bell-notification");
updated_counter.setAttribute("current-count",5);
