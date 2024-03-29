var columnDefs = [
    {headerName: "Athlete", field: "athlete", width: 180, rowGroupIndex: 1,
        // use font awesome for first col, with numbers for sort
        icons: {
            sortAscending: '<i class="fa fa-sort-alpha-asc"/>',
            sortDescending: '<i class="fa fa-sort-alpha-desc"/>'
        },
        cellRenderer: 'group'
    },
    {headerName: "Age", field: "age", width: 90, enableValue: true,
        icons: {
            // not very useful, but demonstrates you can just have strings
            sortAscending: 'U',
            sortDescending: 'D'
        }
    },
    {headerName: "Country", field: "country", width: 120, rowGroupIndex: 0, enableRowGroup: true,
        icons: {
            sortAscending: '<i class="fa fa-sort-alpha-asc"/>',
            sortDescending: '<i class="fa fa-sort-alpha-desc"/>'
        }
    },
    {headerName: "Year", field: "year", width: 90, enableRowGroup: true,
        // mix it up a bit, use a function to return back the icon
        icons: {
            sortAscending: function () { return 'ASC'; },
            sortDescending: function () { return 'DESC'; }
        }
    },
    {headerName: "Date", field: "date", width: 110},
    {headerName: "Sport", field: "sport", width: 110},
    {headerName: "Gold", field: "gold", width: 100},
    {headerName: "Silver", field: "silver", width: 100},
    {headerName: "Bronze", field: "bronze", width: 100},
    {headerName: "Total", field: "total", width: 100}
];

var gridOptions = {
    columnDefs: columnDefs,
    rowData: null,
    showToolPanel: true,
    enableSorting: true,
    enableFilter: true,
    enableColResize: true,
    groupSuppressAutoColumn: true,
    // override all the defaults with font awesome
    icons: {
        // use font awesome for menu icons
        menu: '<i class="fa fa-bars"/>',
        filter: '<i class="fa fa-filter"/>',
        sortAscending: '<i class="fa fa-long-arrow-down"/>',
        sortDescending: '<i class="fa fa-long-arrow-up"/>',
        // use some strings from group
        groupExpanded: '<img src="minus.png" style="width: 15px;"/>',
        groupContracted: '<img src="plus.png" style="width: 15px;"/>',
        columnMovePin: '<i class="fa fa-hand-grab-o"/>',
        columnMoveAdd: '<i class="fa fa-plus-square-o"/>',
        columnMoveHide: '<i class="fa fa-remove"/>',
        columnMoveMove: '<i class="fa fa-chain"/>',
        columnMoveLeft: '<i class="fa fa-arrow-left"/>',
        columnMoveRight: '<i class="fa fa-arrow-right"/>',
        columnMoveGroup: '<i class="fa fa-group"/>',
        rowGroupPanel: '<i class="fa fa-bank"/>',
        pivotPanel: '<i class="fa fa-magic"/>',
        valuePanel: '<i class="fa fa-magnet"/>',
        menuPin: 'P', // just showing letters, no graphic
        menuValue: 'V',
        menuAddRowGroup: 'A',
        menuRemoveRowGroup: 'R',
        clipboardCopy: '>>',
        clipboardPaste: '>>'
    }
};

// setup the grid after the page has finished loading
document.addEventListener('DOMContentLoaded', function() {
    var gridDiv = document.querySelector('#myGrid');
    new agGrid.Grid(gridDiv, gridOptions);

    // do http request to get our sample data - not using any framework to keep the example self contained.
    // you will probably use a framework like JQuery, Angular or something else to do your HTTP calls.
    var httpRequest = new XMLHttpRequest();
    httpRequest.open('GET', '../olympicWinners.json');
    httpRequest.send();
    httpRequest.onreadystatechange = function() {
        if (httpRequest.readyState == 4 && httpRequest.status == 200) {
            var httpResult = JSON.parse(httpRequest.responseText);
            gridOptions.api.setRowData(httpResult);
        }
    };
});
