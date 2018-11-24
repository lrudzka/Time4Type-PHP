document.addEventListener('DOMContentLoaded', function () {
    
    
    // wyszukiwanie drużyn
    
    var searchInput = document.querySelector('input.searchTeam');
    
    searchInput.addEventListener('keyup', function(e){
        var input, filter, table, tr, td, i;
        input = e.target;
        filter = input.value.toUpperCase();
        table = document.querySelector("table.history");
        tr = table.getElementsByTagName("tr");

        // Loop through all table rows, and hide those who don't match the search query
        for (i = 0; i < tr.length; i++) {
            td1 = tr[i].getElementsByTagName("td")[1];
            td2 = tr[i].getElementsByTagName("td")[3];
            if (td1) {
                if ( (td1.innerHTML.toUpperCase().indexOf(filter) > -1) ||
                     (td2.innerHTML.toUpperCase().indexOf(filter) > -1)  ) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            } 
        }
    });
    
    // sortowanie tabeli
    
    var sortButton = document.querySelector('button.sort');
    
    sortButton.addEventListener('click', function(e){
        e.target.classList.toggle('sortUp');
        e.target.classList.toggle('sortDown');
        
        var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
        table = document.querySelector("table.history");
        switching = true;
        // Set the sorting direction to ascending:
        dir = "asc"; 
        /* Make a loop that will continue until
        no switching has been done: */
        while (switching) {
            // Start by saying: no switching is done:
           switching = false;
           rows = table.rows;
           /* Loop through all table rows (except the
           first, which contains table headers): */
           for (i = 1; i < (rows.length - 1); i++) {
               // Start by saying there should be no switching:
               shouldSwitch = false;
               /* Get the two elements you want to compare,
               o ne from current row and one from the next: */
               x = rows[i].getElementsByTagName("TD")[0];
               y = rows[i + 1].getElementsByTagName("TD")[0];
               /* Check if the two rows should switch place,
               based on the direction, asc or desc: */
               if (dir == "asc") {
                   if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                   // If so, mark as a switch and break the loop:
                   shouldSwitch = true;
                   break;
                   }
               } else if (dir == "desc") {
                   if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                   // If so, mark as a switch and break the loop:
                   shouldSwitch = true;
                   break;
                   }
               }
           }
           if (shouldSwitch) {
               /* If a switch has been marked, make the switch
               and mark that a switch has been done: */
               rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
               switching = true;
               // Each time a switch is done, increase this count by 1:
               switchcount ++; 
           } else {
               /* If no switching has been done AND the direction is "asc",
               set the direction to "desc" and run the while loop again. */
               if (switchcount == 0 && dir == "asc") {
                   dir = "desc";
                   switching = true;
               }
           }
        }
        
    });

    for (var i=0; i<deleteBtn.length; i++)
    {
        deleteBtn[i].addEventListener("click", function(e){
            var tableRow = e.target.parentElement.parentElement;
            var homeTeam = tableRow.querySelector("td.home").innerHTML;
            var awayTeam = tableRow.querySelector("td.away").innerHTML;
            var game = homeTeam+" : "+awayTeam;
            
            if (!confirm("Czy na pewno chcesz usunąć swój typ dla meczu "+game+" ?"))
            {
                e.preventDefault();
            }
            
        });
    }
});