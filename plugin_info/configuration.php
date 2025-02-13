
<?php
   /* This file is part of Jeedom.
    *
    * Jeedom is free software: you can redistribute it and/or modify
    * it under the terms of the GNU General Public License as published by
    * the Free Software Foundation, either version 3 of the License, or
    * (at your option) any later version.
    *
    * Jeedom is distributed in the hope that it will be useful,
    * but WITHOUT ANY WARRANTY; without even the implied warranty of
    * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
    * GNU General Public License for more details.
    *
    * You should have received a copy of the GNU General Public License
    * along with Jeedom. If not, see <http://www.gnu.org/licenses/>.
    */

   require_once dirname(__FILE__) . '/../../../core/php/core.inc.php';
   include_file('core', 'authentification', 'php');
   if (!isConnect()) {
       include_file('desktop', '404', 'php');
       die();
   }
   $plugin = plugin::byId('lgthinq2');
   sendVarToJS('version', lgthinq2::$_pluginVersion);

   ?>

<form class="form-horizontal">
   <fieldset>
      <legend>
         <i class="fa fa-list-alt"></i> {{Général}}
      </legend>
      <div class="form-group">
         <?php
            $update = $plugin->getUpdate();
            if (is_object($update)) {
                echo '<div class="col-lg-3">';
                echo '<div>';
                echo '<label>{{Branche}} :</label> '. $update->getConfiguration('version', 'stable');
                echo '</div>';
                echo '<div>';
                echo '<label>{{Source}} :</label> ' . $update->getSource();
                echo '</div>';
                echo '<div>';
                echo '<label>{{Version}} :</label> v' . ((lgthinq2::$_pluginVersion)?lgthinq2::$_pluginVersion:' '). ' (' . $update->getLocalVersion() . ')';
                echo '</div>';
                echo '</div>';
            }
            ?>
         <div class="col-lg-5">
            <div>
               <i><a class="btn btn-primary btn-xs" target="_blank" href="https://flobul-domotique.fr/presentation-du-plugin-lgthinq2-pour-jeedom/"><i class="fas fa-book"></i><strong> {{Présentation du plugin}}</strong></a></i>
               <i><a class="btn btn-success btn-xs" target="_blank" href="<?=$plugin->getDocumentation()?>"><i class="fas fa-book"></i><strong> {{Documentation complète du plugin}}</strong></a></i>
            </div>
            <div>
               <i> {{Les dernières actualités du plugin}} <a class="btn btn-label btn-xs" target="_blank" href="https://community.jeedom.com/t/plugin-lgthinq2-documentation-et-actualites/39994"><i class="icon jeedomapp-home-jeedom icon-lgthinq2"></i><strong>{{sur le community}}</strong></a>.</i>
            </div>
            <div>
               <i> {{Les dernières discussions autour du plugin}} <a class="btn btn-label btn-xs" target="_blank" href="https://community.jeedom.com/tags/plugin-lgthinq2"><i class="icon jeedomapp-home-jeedom icon-lgthinq2"></i><strong>{{sur le community}}</strong></a>.</i></br>
               <i> {{Pensez à mettre le tag}} <b><font font-weight="bold" size="+1">#plugin-lgthinq2</font></b> {{et à fournir les log dans les balises préformatées}}.</i>
            </div>
            <style>
               .icon-lgthinq2 {
                   font-size: 1.3em;
                   color: #94CA02;
               }

               :root{
                 --background-color: #1987ea;
                }
            </style>
         </div>
      </div>
      <div class="form-group">
        <legend>
		<i class="fas fa-cogs"></i> {{Paramètres}}
		</legend>
          <div class="form-group">
              <label class="col-lg-4 control-label">{{Intervalle de rafraîchissement des informations (cron)}}
      <sup><i class="fas fa-question-circle" title="{{Sélectionnez l'intervalle auquel le plugin ira récupérer les informations sur les serveurs Creality.}}"></i></sup>
              </label>
              <div class="col-lg-4">
                  <select class="configKey form-control" data-l1key="autorefresh" >
                      <option value="* * * * *">{{Toutes les minutes}}</option>
                      <option value="*/2 * * * *">{{Toutes les 2 minutes}}</option>
                      <option value="*/3 * * * *">{{Toutes les 3 minutes}}</option>
                      <option value="*/4 * * * *">{{Toutes les 4 minutes}}</option>
                      <option value="*/5 * * * *">{{Toutes les 5 minutes}}</option>
                      <option value="*/10 * * * *">{{Toutes les 10 minutes}}</option>
                      <option value="*/15 * * * *">{{Toutes les 15 minutes}}</option>
                      <option value="*/30 * * * *">{{Toutes les 30 minutes}}</option>
                      <option value="*/45 * * * *">{{Toutes les 45 minutes}}</option>
                      <option value="">{{Jamais}}</option>
                  </select>
              </div>
          </div>

      <div class="form-group">
		<legend>
		    <i class="fas fa-user-cog"></i> {{Authentification}}
		</legend>

        <div class="form-group">
          <label class="col-sm-2 control-label"><strong> {{Identifiant}}</strong>
              <sup><i class="fas fa-question-circle" title="{{Entrez l'identifiant.}}"></i></sup>
          </label>
          <div class="col-sm-4">
              <input type="text" class="configKey form-control" data-l1key="id" placeholder="adresse@email.com"></input>
          </div>
          <label class="col-sm-2 control-label"><strong> {{Mot de passe}}</strong>
              <sup><i class="fas fa-question-circle" title="{{Entrez le mot de passe.}}"></i></sup>
          </label>
          <div class="input-group col-sm-2">
              <input type="password" class="inputPassword configKey form-control" data-l1key="password" placeholder="password">
              <span class="input-group-btn">
                  <a class="btn btn-default form-control bt_showPass roundedRight"><i class="fas fa-eye"></i></a>
              </span>
          </div>
        </div>
          
        <div class="form-group">
          <label class="col-sm-2 control-label"><strong> {{Connexion}}</strong>
              <sup><i class="fas fa-question-circle" title="{{Connexion}}"></i></sup>
          </label>
          <div class="col-sm-2">
             <a id="bt_getCredentials" class="btn btn-success" style="width:30px"><i class="fas fa-check"></i>{{}}</a>
          </div>
        </div>
      </div>
      </div>
   </fieldset>
</form>
<script>
       $('#bt_getCredentials').on('click', function() {
          if ($('.configKey[data-l1key="id"]').value() == '' || $('.configKey[data-l1key="password"]').value() == '') {
              $.fn.showAlert({
                  message: '{{Veuillez entrer un identifiant et un mot de passe de connexion.}}',
                  level: 'danger'
              });
              return;
          }
          $.ajax({
                type: "POST",
                url: "plugins/lgthinq2/core/ajax/lgthinq2.ajax.php",
                data: {
                  action: "getCredentials"
                },
                dataType: 'json',
                error: function(request, status, error) {
                  handleAjaxError(request, status, error);
                },
                success: function(data) {
                  console.log(data)
                  if (data.state != 'ok') {
                    $.fn.showAlert({
                      message: data.result,
                      level: 'danger'
                    });
                    return;
                  }
                }
              });
        });

</script>

<?php include_file('desktop', 'configuration', 'js', 'lgthinq2'); ?>