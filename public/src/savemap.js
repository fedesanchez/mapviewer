Ext.ns("gxp.SaveMap");

gxp.plugins.SaveMap = Ext.extend(gxp.plugins.Tool, {

  ptype: "gxp_savemap",

  addActions: function() {

  	var action = new GeoExt.Action({
        text: "Save",      
        allowDepress: false,
        map: this.map,
        control: new OpenLayers.Control(),
        handler: function (){ 
                var center=app.mapPanel.map.getCenter();
                var zoom=app.mapPanel.map.getZoom();
                app.map.center=[center.lon,center.lat];
                app.map.zoom=zoom;
                
                var portalconfig = "{ 'portalConfig':"+ Ext.util.JSON.encode(app.portalConfig) +"}";
                var tools='';//Ext.util.JSON.encode(app.tools);
                var sources="{ 'sources' :"+ Ext.util.JSON.encode(app.sources) + "}";
                var map="{ 'map' :"+ Ext.util.JSON.encode(app.map) + "}";
                var description="mi descripcion";


                var method, url;
                if (id=="sacar esto") {
                    method = "PUT";
                    url = "../maps/" + this.id;
                } else {
                    method = "POST";
                    url = "maps.php";
                }
            
                
                var requestConfig = {
                    method: method,
                    url: url,
                    data: OpenLayers.Util.getParameterString({portalconfig: portalconfig,tools:tools,sources:sources,map:map,description:description}),
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded"
                    },
                    callback:function(request){alert("save")}                    
                };
              
                    OpenLayers.Request.issue(Ext.apply(requestConfig));                          
              

            /*  var request = OpenLayers.Request.POST({
                  url: "maps.php",
                  data: OpenLayers.Util.getParameterString({foo: "bar"}),
                  headers: {
                      "Content-Type": "application/x-www-form-urlencoded"
                  },
                  callback: handleSave
              });
          */

        },
        handleSave : function (request) {
          alert("entro");
       } 
  
     });

  
          
    return gxp.plugins.SaveMap.superclass.addActions.apply(this, [action]);
  }

});

Ext.preg(gxp.plugins.SaveMap.prototype.ptype, gxp.plugins.SaveMap);