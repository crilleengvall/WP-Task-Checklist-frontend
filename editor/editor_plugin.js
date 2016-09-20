(function() {
     tinymce.create('tinymce.plugins.TaskChecklistFrontend', {
          init : function(ed, url) {
               ed.addButton( 'button_task_checklist', {
                    title : 'Insert tasks',
                    image : url + '/images/check.png',
                    type : 'menubutton'
               }
             );
             this.addMenuItems(ed);
          },

          addMenuItems: function(ed) {
            var menuItems = ed.settings.tcf_categories.split(',');
            ed.buttons.button_task_checklist.menu = [];
            for (i = 0; i < menuItems.length; i++) {
              var id = menuItems[i].split(':')[0];
              var name = menuItems[i].split(':')[1];
              ed.buttons.button_task_checklist.menu.push({text: name,
                id: id,
                onclick: function() {
                  ed.insertContent('[tcf_task categoryid="' + this.settings.id + '" categoryname="' + this.settings.text + '"]');
                }
              });
            }
          },

          createControl : function(n, cm) {
               return null;
          },
     });
     tinymce.PluginManager.add( 'task_checklist_script', tinymce.plugins.TaskChecklistFrontend );
})();
