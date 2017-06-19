<nav class="navbar navbar-inverse navbar-fixed-top">
  <div class="container">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">Gospel Blocks</a>
      <div class="pull-right">
          <div class="btn btn-warning"  data-toggle="modal" data-target="#sign_up_modal">Sign up</div>
          <div class="btn btn-success"  data-toggle="modal" data-target="#login_modal">Sign in</div>
      </div>
    </div>
  </div>
</nav>

<!-- Main jumbotron for a primary marketing message or call to action -->
<div class="jumbotron">
  <div class="container">
    <h1>About Gospel Blocks?</h1>
    <p>This is collabrative study group... sort of... We have gathered togother a complete database of the standard works, starting from Genesis and going to General Conference. This tool allows you to organize verses into blocks and set them in order. </p>
    <p><a class="btn btn-primary btn-lg" href="#" role="button">Learn more »</a></p>
  </div>
</div>

<div class="container">
  <!-- Example row of columns -->
  <div class="row">
    <div class="col-md-4">
      <h2>Timelines</h2>
      <p>View a list of all scriptures relating to prophecies in chronological order on a timeline. </p>
      <p><a class="btn btn-default" href="#" role="button">View details »</a></p>
    </div>
    <div class="col-md-4">
      <h2>Step-by-Step</h2>
      <p>See scriptures relating repentance process, or pride cycle laid in sequential order. </p>
      <p><a class="btn btn-default" href="#" role="button">View details »</a></p>
   </div>
    <div class="col-md-4">
      <h2>Plain ol groups</h2>
      <p>View the principles of liberty, or any other groups you would like to create</p>
      <p><a class="btn btn-default" href="#" role="button">View details »</a></p>
    </div>
  </div>

  <!-- Sign Up Modal -->
  <div class="modal fade" id="sign_up_modal" role="dialog">
    <div class="modal-dialog">
      <!-- Sign Up Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Sign Up</h4>
        </div>
        <div class="modal-body">
          <form id="sign_up_form" class="form_submit" method="post">
              <input type="hidden" name="function" value="sign_up">
            <div class="form-group">
              <input type="text" placeholder="User Name" name='display_name' class="form-control">
            </div><br/>
            <div class="form-group">
              <input type="text" placeholder="Email" name='email' class="form-control">
            </div><br/>
            <div class="form-group">
              <input type="password" placeholder="Password" name="password" class="form-control">
            </div><br/>
            <div class="form-group">
              <input type="password" placeholder="Confirm Password" name="password_chk" class="form-control">
            </div><br/>
            <button type="submit" type="submit" class="btn btn-warning">Sign Up</button>
          </form>
        </div>
      </div>

    </div>
  </div>
  <!-- Login Modal -->
  <div class="modal fade" id="login_modal" role="dialog">
    <div class="modal-dialog">
      <!-- Sign Up Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Sign Up</h4>
        </div>
        <div class="modal-body">
          <form id="login_form"  class="form_submit">
            <input type="hidden" name="function" value="login">
            <div class="form-group">
              <input type="text" placeholder="Email" name='email' class="form-control">
            </div>
            <div class="form-group">
              <input type="password" placeholder="Password" name="password" class="form-control">
            </div>
            <button type="submit" class="btn btn-success">Sign in</button>
          </form>
        </div>
      </div>

    </div>
  </div>
  <hr>
  <footer>
    <p>© 2016 Gospel Blocks, Inc.</p>
  </footer>
</div> <!-- /container -->
<script type="text/javascript">

</script>
