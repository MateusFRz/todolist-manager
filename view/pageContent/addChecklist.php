    <div class="card" style="width: 20rem;">
        <div class="card-header">
            <h5 class="card-title">Add checklist</h5>
        </div>
        <div class="card-body">
            <form method="post">
                <div class="form-group">
                    <label for="checklistNameIn">Checklist name</label>
                    <input type="text" id="checklistNameIn" class="form-control" placeholder="Checklist name" name="checklistName">
                </div>
                <div class="form-group">
                    <label for="taskName">Task name</label>
                    <input type="text" id="taskName" class="form-control" placeholder="Task name" name="taskName">
                </div>

                <div class="from-group">
                    <label for="taskDesc">Description</label>
                    <textarea rows="3" class="form-control" name="taskDesc" id="taskDesc" placeholder="Description"></textarea>
                </div>
                <?php if (Validation::isUser($_SESSION['user'])):?>
                 <br>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="private" name="private" value="yes">
                    <label class="form-check-label" for="private">Private</label>
                </div>
                <?php endif;?>
                <br>
                <div class="text-right">
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
                <input type="hidden" name="action" value="addChecklist">
            </form>
        </div>
    </div>