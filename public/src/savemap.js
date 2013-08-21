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
              
                var description="mi descripcion";

                var configStr = Ext.util.JSON.encode(app.getState());
                

                var method, url;
                if (app._id) {
                    method = "PUT";
                    url = "maps.php/" + app._id;
                } else {
                    method = "POST";
                    url = "maps.php";
                }
            
            
                
                var requestConfig = {
                    method: method,
                    url: url,
                    data: OpenLayers.Util.getParameterString({map:configStr,description:description}),                    
                    headers: {
                              "Content-Type": "application/x-www-form-urlencoded"
                            },
                    callback:function(response){
                              var obj = Ext.util.JSON.decode(response.responseText);
                              var data=obj[0].data;
                                if(data.id){
                                   if(method == "POST")window.location="view.php?id="+ data.id;
                                   if(method == "PUT")alert("se edito el mapa");
                                }
                            }                    
                };
              
                    OpenLayers.Request.issue(Ext.apply(requestConfig));                          
              


        },
        handleSave : function (request) {
          alert("entro");
       } 
  
     });

  
          
    return gxp.plugins.SaveMap.superclass.addActions.apply(this, [action]);
  }

});

Ext.preg(gxp.plugins.SaveMap.prototype.ptype, gxp.plugins.SaveMap);


