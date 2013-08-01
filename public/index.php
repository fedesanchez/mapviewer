<!DOCTYPE html>
<html>
    <head>
        <title>Segunda version</title>

        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="shortcut icon" href="./favicon.ico">
        <!-- Ext resources -->
        <link rel="stylesheet" type="text/css" href="src/ext/resources/css/ext-all.css">
        <link rel="stylesheet" type="text/css" href="src/ext/resources/css/xtheme-gray.css">
        <script type="text/javascript" src="src/ext/adapter/ext/ext-base.js"></script>
        <script type="text/javascript" src="src/ext/ext-all.js"></script>

        
        <!-- app resources -->
        <link rel="stylesheet" type="text/css" href="theme/app/style.css">
        
        <script>
        Ext.onReady(function() {

          var store = new Ext.data.JsonStore({
            // store configs
            autoDestroy: true,
            autoLoad:true,
            url: 'maps.php',
            storeId: 'myStore',
            // reader configs
            root: 'request',
            idProperty: 'id',
            fields: ['id', 'config', 'description']
          });
          var grid = new Ext.grid.GridPanel({
                store: store,
                renderTo:"grid-panel",
                colModel: new Ext.grid.ColumnModel({
                    defaults: {
                    width: 120,
                    sortable: true
                    },  
                    columns: [
                        {header: 'Id', width: 20, sortable: true, dataIndex: 'id'},
                        {header: 'Config', dataIndex: 'config'},
                        {header: 'Description', dataIndex: 'description'},
                        {header: '-',
                         dataIndex: 'id',
                         renderer: function(value, metaData, record, rowIndex, colIndex, store) {
                            var href='composer.php?id=/'+value;
                            return "<a target=_blank href='"+href+"'> ver mapa</a>";
                         }
                        }                         
                    ]           
                }),
                viewConfig: {
                    forceFit: true,
                    getRowClass: function(record, index) {}
                },
                sm: new Ext.grid.RowSelectionModel({singleSelect:true}),
                width: 600,
                height: 300,
                frame: true,
                title: 'Framed with Row Selection and Horizontal Scrolling',
                iconCls: 'icon-grid'
            });
          
          });
        </script>
    </head>
    <body>

        <div id="grid-panel"></div>

    </body>
</html>
