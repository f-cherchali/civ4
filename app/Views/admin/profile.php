<div class="row">
    <div class="col-md-12">
        <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Editer les informations</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" method="POST" name="updateProfile" action="<?=site_url("admin/profile")?>">
                <div class="card-body">
                  <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control disabled" id="email" value="<?=$adminData->email?>" disabled="disabled">
                  </div>
                  <div class="form-group">
                    <label for="last_name">Nom</label>
                    <input type="last_name" class="form-control" id="last_name" value="<?=$adminData->last_name?>">
                  </div>
                  <div class="form-group">
                    <label for="first_name">Prénom</label>
                    <input type="first_name" class="form-control" id="first_name" value="<?=$adminData->first_name?>">
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>
              </form>
        </div>
    </div>
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Photo de profile</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <div class="card-body">
              <form action="">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="profilephoto">Choisissez votre photo</label>
                      <input type="file" name="profilephoto" id="profilephoto">
                    </div>
                  </div>
                  <div class="col-md-6 text-center">
                    <img width="200" height="200" id="image" src="<?=($sessview->admin_profile=="")?site_url("assets/img/defaultuser.png"):site_url('$sessview->admin_profile')?>">
                    <button id="validate">Appliquer</button>
                  </div>
                </div>
              </form>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Mettre à jour votre mot de passe</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" method="POST" name="updatePassword" action="<?=site_url("admin/profile")?>">
                <div class="card-body">
                    <div class="form-group">
                        <label for="password">Votre mot de passe actuel</label>
                        <input type="password" name="password" class="form-control" id="password" placeholder="Mot de passe actuel">
                    </div>
                    <div class="form-group">
                        <label for="newpassword">Votre nouveau mot de passe</label>
                        <input type="newpassword" name="newpassword" class="form-control" id="newpassword" placeholder="Nouveau mot de passe (Min 8 caractères)">
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Mettre à jour</button>
                </div>
            </form>
        </div>
</div>