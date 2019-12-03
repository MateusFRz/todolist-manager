<div class="col-4">
    <div class="card" style="width: 20rem;">
        <div class="card-header">
            <h5 class="card-title">Add checklist</h5>
        </div>
        <div class="card-body">
            <form method="post">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" id="name" class="form-control" placeholder="Checklist name" name="name">
                </div>

                <div class="from-group">
                    <label for="tasks">Task</label>
                    <textarea rows="5" class="form-control" name="tasks" id="tasks" placeholder="Use § to delimit task name and description and ; to delimit each task"></textarea>
                </div>
                <?php if(isset($_SESSION['login'])):?>
                 <br>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="public" name="public" value="yes">
                    <label class="form-check-label" for="public">Private</label>
                </div>
                <?php endif;?>
                <br>
                <button type="submit" class="btn btn-primary">Add</button>
                <input type="hidden" name="action" value="addChecklist">
            </form>
        </div>
    </div>
</div>