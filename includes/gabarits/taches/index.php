<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Taches</title>
    <link rel="stylesheet" href="https://unpkg.com/purecss@1.0.0/build/pure-min.css" integrity="sha384-nn4HPE8lTHyVtfCBi5yW9d20FjT8BJwUXyWZT9InLYax14RDjBj46LmSztkmNP9w" crossorigin="anonymous">
    <link rel="stylesheet" href="https://unpkg.com/purecss@1.0.0/build/grids-responsive-min.css">
    <link rel="stylesheet" href="styles/taches.css">
  </head>
  <body>
    <section id="layout" class="pure-g">
      <aside class="sidebar pure-u-1 pure-u-md-1-5">
          <header class="header">
              <h1 class="brand-title">TADA</h1>
              <h2 class="brand-tagline">Do Sans Bavure</h2>
          </header>
      </aside>
      <section class="content pure-u-1 pure-u-md-4-5">
        <head>
          <h1>Tâches</h1>
          <h2>… ajouter / modifier / supprimer / rechercher / date / status / ip…</h2>
        </head>
        <table class="pure-table">
          <thead>
            <tr>
              <td colspan="3">
                <form action="?controleur=taches&action=ajouter" class="pure-form"  method="post">
                  <!--label>Nouvelle :</label-->
                  <input type="submit" value="Ajouter" class="pure-button pure-button-primary">
                  <input type="text" size="60" name="texte" id="tache-texte">
                </form>

                <form action="?controleur=taches&action=lister" class="pure-form"  method="post">
                  <!--label>Recherche :</label-->
                  <input type="submit" value="Recherche" class="pure-button pure-button-primary">
                  <input type="text" size="60" name="texte" id="tache-texte">
                </form>

              </td>
            </tr>
            <th>Fait</th>
            <th style="display:flex;">
              <form action="?controleur=taches&action=mettreAJour" class=""  method="post">
                <input type="submit" value="Mettre à jour" class="">
              </form>
              <form action="?controleur=taches&action=lister" class=""  method="post">
                <input type="hidden" name="termine" value="termine">
                <input type="submit" value="Tâches terminées" class="">
              </form>
              <form action="?controleur=taches&action=lister" class=""  method="post">
                <input type="hidden" name="termine" value="enAttente" >
                <input type="submit" value="Tâches en attentes" class="">
              </form>
              <form action="?controleur=taches&action=effacer" class=""  method="post">
                <input type="hidden" value="termine" name="id" />
                <input type="submit" value="- Terminées" class="">
              </form>
            </th>
            <td></td>
          </thead>
          <tbody>
            <?php foreach($taches as $t) { ?>
             <tr>
              <td>    
                <form action="?controleur=taches&action=modifier" class="pure-form"  method="post">
                  <input type="hidden" value="<?= $t->id ?>" name="id" />
                  <input type="hidden" value="termine" name="termine" />
                  <input type="checkbox" value="enAttente" <?php if ($t->termine == "termine") { echo"checked"; } ?>  name="termine" onchange="javascript:this.form.submit();"/>
                </form>
                
              </td>
              <td>
                <form action="?controleur=taches&action=modifier" class="pure-form"  method="post">
                  <input type="hidden" value="<?= $t->id ?>" name="id" />
                  <input type="text" value="<?= $t->ip ?>" size="13" name="texte" <?php if ($t->termine == "termine") { echo "disabled"; } ?>/>
                  <input type="text" value="<?= $t->texte ?>" size="13" name="texte" <?php if ($t->termine == "termine") { echo "disabled"; } ?>/>
                  <input type="text" value="<?= $t->dateDebut ?>" size="13" name="texte" <?php if ($t->termine == "termine") { echo "disabled"; } ?>/>
                  <input type="text" value="<?= $t->termine ?>" size="13" name="texte" <?php if ($t->termine == "termine") { echo "disabled"; } ?>/>
                  <input type="submit" value="Modifier" />
                </form>
              </td>
              <td>
                <form action="?controleur=taches&action=effacer" class="pure-form"  method="post">
                  <input type="hidden" value="<?= $t->id ?>" name="id" />
                  <input type="submit" value="✗" class="pure-button" />
                </form>
              </td>
            </tr>
          <?php } ?>
          </tbody>
        </table>
      </section>
    </section>
  </body>
</html>
