<?php require APPROOT . "/views/inc/header.php" ?>
<div class="container">
    <h1><?php echo $data["title"]; ?></h1>
    <div class="row">
        <hr>
        <div class="col-sm-4">
            <h2>Add and delete branch</h2>
            <a href="javascript:void(0)" class="btn btn-success init-add-form"><span class="icon expand-icon glyphicon glyphicon-floppy-save"></span>Add</a>
            <a href="javascript:void(0)" class="btn btn-danger init-delete-form"><span class="icon expand-icon glyphicon glyphicon-floppy-remove"></span>Delete</a>
            <div class="add-form-cnt nested">
                <form class="add-form" action="<?php echo URLROOT; ?>/forms/add/" method="get">
                    <div class="form-group">
                        <label for="input-select-node" class="sr-only">Name branch:</label>
                        <input type="input" class="form-control" id="input-select-node" placeholder="Enter name branch" name="name_branch" value="">
                    </div>
                    <div class="form-group">
                        <?php if(!empty($data["branches"])) :?>
                            <select class="form-control selectpicker" id="select-expand-node-levels" name="parent_branch">
                                <option>Select parent branch</option>
                                <?php foreach($data["branches"] as $id => $branch) : ?>
                                    <option data-id="<?php echo $branch->id?>"><?php echo $branch->name; ?></option>
                                <?php endforeach; ?>
                            </select>
                        <?php endif;?>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-success" id="btn-select-node">Add branch</button>
                    </div>
                </form>
            </div>
            <div class="delete-form-cnt nested">
                <form class="delete-form" action="<?php echo URLROOT; ?>/forms/delete/" method="post">
                    <div class="form-group">
                        <?php if(!empty($data["branches"])) :?>
                            <select class="form-control selectpicker" id="select-expand-node-levels" name="parent_branch">
                                <option>Select parent branch</option>
                                <?php foreach($data["branches"] as $id => $branch) : ?>
                                    <option data-id="<?php echo $branch->id?>"><?php echo $branch->name; ?></option>
                                <?php endforeach; ?>
                            </select>
                        <?php endif;?>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-danger select-node" id="btn-unselect-node">Delete branch</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-sm-4">
            <h2>Tree</h2>
            <div id="treeview-selectable">
                <ul id="treeview">
                    <?php if(!empty($data["branches"])) :?>
                        <?php foreach($data["parents"] as $id => $parent) : ?>
                            <?php if(!empty($parent["name"])) : ?>
                                <li data-id="<?php echo $id?>">
                                    <?php if($parent["hasChildren"]) : ?>
                                        <span class="icon expand-icon glyphicon glyphicon-plus"></span>
                                        <span class="icon node-icon"></span>
                                    <?php endif;?>
                                    <?php echo $parent["name"]?>
                                </li>
                            <?php endif;?>
                        <?php endforeach;?>
                    <?php endif;?>
                </ul>
            </div>
        </div>
        <div class="col-sm-4">
            <h2>Events</h2>
            <div id="selectable-output"></div>
        </div>
    </div>
</div>
<?php require APPROOT . "/views/inc/footer.php" ?>
