    <div class="card p-0" style="width: 20rem;">
        <div class="card-header">
            <h5 class="card-title">Add checklist</h5>
        </div>
        <div class="card-body">
            <form method="post">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" id="name" class="form-control" placeholder="Checklist name" name="name">
                </div>
                <div class="form-group">
                    <label for="taskName">ame</label>
                    <input type="text" id="name" class="form-control" placeholder="taskName name" name="taskName">
                </div>

                <div class="from-group">
                    <label for="taskDesc">Task</label>
                    <textarea rows="5" class="form-control" name="taskDesc" id="taskDesc" placeholder="Task description"></textarea>
                </div>
                <?php if (Validation::isUser($_SESSION['user'])):?>
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