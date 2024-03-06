@extends('layout.master')

@section('content')
<div class="container shadow">
    <div class="row">
        <div class="col-md-8">
            <h1>All Tags</h1>
        </div>
        <div class="col-md-4 my-3">
            <a href="{{ route('instructor.course.tags-create') }}" class="btn btn-primary float-md-end">Create Tags</a>
        </div>
    </div>

    <!-- Live Search Bar -->
    <form action="{{ route('instructor.course.tags') }}" method="GET" class="my-3 row">
        <div class="col-md-4 offset-md-8">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Search" name="search" value="{{ request('search') }}" id="liveSearchInput">
                <button class="btn btn-outline-secondary" type="submit">Search</button>
            </div>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table" id="tagsTable">
            <thead>
                <tr>
                    <th onclick="sortTable(0)">Tag <span id="tagSortIcon">&#8593;</span></th>
                    <th onclick="sortTable(1)">Course <span id="courseSortIcon">&#8593;</span></th>
                    <th class="text-center">Paid</th>
                    <th class="text-center">Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($courses as $course)
                    <tr>
                        <td>
                            @foreach ($course->tags as $tag)
                                <span class="badge bg-info">{{ $tag->name }}</span>
                            @endforeach
                        </td>
                        <td>{{ $course->title }}</td>
                        <td>{{ $course->paid == 1 ? 'Paid' : 'Free' }}</td>
                        <td>{{ $course->sales->sum('amount') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    // Sorting function
    function sortTable(columnIndex) {
        var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
        table = document.querySelector("#tagsTable");
        switching = true;
        // Set the sorting direction to ascending:
        dir = "asc";
        // Loop until no switching has been done:
        while (switching) {
            switching = false;
            rows = table.rows;
            // Loop through all table rows (except the first, which contains table headers):
            for (i = 1; i < rows.length - 1; i++) {
                shouldSwitch = false;
                // Get the two elements you want to compare, one from the current row and one from the next:
                x = rows[i].getElementsByTagName("td")[columnIndex];
                y = rows[i + 1].getElementsByTagName("td")[columnIndex];
                // Check if the two rows should switch place, based on the direction, and update the direction accordingly:
                if (dir == "asc" && x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                    shouldSwitch = true;
                    break;
                } else if (dir == "desc" && x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                    shouldSwitch = true;
                    break;
                }
            }
            if (shouldSwitch) {
                // If a switch has been marked, make the switch and mark that a switch has been done:
                rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                switching = true;
                // Each time a switch is done, increase this count by 1:
                switchcount++;
            } else {
                // If no switching has been done and the direction is "asc", set the direction to "desc" and run the while loop again:
                if (switchcount == 0 && dir == "asc") {
                    dir = "desc";
                    switching = true;
                }
            }
        }
        // Update sorting icons
        updateSortIcons(columnIndex, dir);
    }

    // Update sorting icons
    function updateSortIcons(columnIndex, direction) {
        var sortIconIds = ['tagSortIcon', 'courseSortIcon'];
        // Reset all icons
        sortIconIds.forEach(function (iconId) {
            document.getElementById(iconId).innerHTML = '&#8593;';
        });
        // Set the icon for the current column based on the sorting direction
        document.getElementById(sortIconIds[columnIndex]).innerHTML = direction === 'asc' ? '&#8593;' : '&#8595;';
    }

    // Live Search
    document.getElementById('liveSearchInput').addEventListener('input', function () {
        var filter, table, tr, td, i, txtValue;
        filter = this.value.toUpperCase();
        table = document.querySelector("#tagsTable");
        tr = table.getElementsByTagName("tr");
        // Loop through all table rows, and hide those who don't match the search query:
        for (i = 1; i < tr.length; i++) { // Start from 1 to skip the header row
            td = tr[i].getElementsByTagName("td")[0]; // Change the index to the column you want to search
            if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                    // Add fade-in animation
                    tr[i].classList.add("fade-in");
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    });

</script>

<style>
    table th {
        cursor: pointer;
    }

    .fade-in {
        animation: fadeIn ease 2s;
        -webkit-animation: fadeIn ease 2s;
        -moz-animation: fadeIn ease 2s;
        -o-animation: fadeIn ease 2s;
        -ms-animation: fadeIn ease 2s;
        transition: opacity 0.5s;
    }

    @keyframes fadeIn {
        0% {
            opacity: 0;
        }

        100% {
            opacity: 1;
        }
    }

    @-moz-keyframes fadeIn {
        0% {
            opacity: 0;
        }

        100% {
            opacity: 1;
        }
    }

    @-webkit-keyframes fadeIn {
        0% {
            opacity: 0;
        }

        100% {
            opacity: 1;
        }
    }

    @-o-keyframes fadeIn {
        0% {
            opacity: 0;
        }

        100% {
            opacity: 1;
        }
    }

    @-ms-keyframes fadeIn {
        0% {
            opacity: 0;
        }

        100% {
            opacity: 1;
        }
    }
</style>
@endsection
