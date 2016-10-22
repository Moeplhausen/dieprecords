<!-- Modal -->
<div class="modal fade" id="managerlogin" tabindex="-1" role="dialog" aria-labelledby="managerloginlabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="managerloginlabel">Login</h4>
            </div>
            <div class="modal-body">
                <!-- Add login for managers form -->
                <form action="/login" method="POST">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="inputname">email:</label>
                        <input type="email" class="form-control" id="inputname" name="inputname">
                    </div>
                    <div class="form-group">
                        <label for="password">Pasword:</label>
                        <input type="password" class="form-control" id="password" name="password"
                               placeholder="password">
                    </div>
                    <button type="submit" class="btn btn-primary">Login</button>
                </form>

            </div>
        </div>
    </div>
</div>