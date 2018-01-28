<style>
input[type="file"] {
    display: none;
}
</style>

<!-- change profile image modal -->
<div class="modal fade" id="update-profile-image-modal" 
    tabindex="-1" role="dialog" 
    aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title" id="myModalLabel">Profile Image</h4>
      </div>
      <div class="modal-body">
            <form id="update-profile-image-form" 
                action="{{ route('admin.users.setProfileImage', $user->id) }}" 
                method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                {{ method_field('PUT') }}

                <!-- image -->
                <div class="form-group">
                    <label for="profile-image" class="btn btn-sm btn-primary" >Browse Locally
                        <input type="file" name="profile-image" id="profile-image" />
                    </label>
                </div>
                
                <div class="form-group">
                    <input type="submit" class="btn btn-primary" value="Save changes" />
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
      </div>

    </div>
  </div>
</div>
