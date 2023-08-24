<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <!-- ===== Boostrap CSS ==== -->
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM"
          crossorigin="anonymous">
</head>
<body>
<div class="card shadow mx-0 mx-lg-3">
    <div class="card-header p-3 shadow">
        <h5 class="mb-0">
            <ion-icon name="list-outline"></ion-icon>
            To Do Tasks
        </h5>
    </div>
    <div class="card-body data-mdb-perfect-scrollbar=true"
         style="position: relative; height: 50vh; overflow-y: scroll">
        <!--======== to do task list =========-->
        <div class="container task-list-container">
            <?php
            $todo_taskNo = 1;
            foreach ($rs2 as $task) {
                if ($task->statues == 0) {
                    ?>
                    <!--============= task card ===========-->
                    <div class="task-card row my-2 shadow rounded-4"
                         style="" type="button"
                         data-bs-toggle="collapse"
                         data-bs-target="#collaps-todo-task-<?php echo $catContentNo ?>-<?php echo $todo_taskNo ?>"
                         aria-expanded="false"
                         aria-controls="collaps-todo-tasks">

                        <div class="col-2 d-flex" style="height: max-content;">
                            <!--                                                                ======== complete task button =========-->
                            <form action="process/taskComplete.php"
                                  method="POST"
                                  id="complete-btn-form-<?php echo $catContentNo ?>-<?php echo $todo_taskNo ?>">

                                <input type="hidden" name="task_id"
                                       value="<?php echo $task->task_id ?>"/>
                                <input type="hidden" name="category_no"
                                       value="<?php echo $catContentNo ?>"/>
                                <div onClick="completeBtn_submitForm(<?php echo $catContentNo ?>,<?php echo $todo_taskNo ?>);"
                                     class="task-complete-icon"></div>
                            </form>

                        </div>
                        <div class="col-6 d-flex">
                            <!--                                                                ===== task name ==========-->
                            <div class="my-auto fw-bold"
                                 style="font-size: 1.5rem;">
                                <?php echo $task->task_name ?>
                            </div>
                        </div>

                        <div class="col-2 d-flex">
                            <!--                                                                ======== display day count for dedaline ===========-->
                            <?php if ($task->deadline !== null) {
                                $today = time();
                                $deadline = strtotime($task->deadline);
                                $days = ceil(($deadline - $today) / 86400);

                                if ($days >= 0) {
                                    ?>

                                    <div class="my-auto d-flex rounded-2 p-1 fw-bold"
                                         style="background-color: var(--darker-primary); color: var(--lighter-secondary);">
                                        <div class="rounded-start-1 px-1"
                                             style="background-color: var(--lighter-secondary); color: var(--darker-primary);">
                                            <?php echo abs($days) ?>
                                        </div>
                                        <div class="ms-1">DAY</div>
                                    </div>
                                    <?php
                                } else {
                                    ?>


                                    <div class="my-auto d-flex rounded-2 p-1 fw-bold"
                                         style="background-color: var(--accent-color); color: var(--lighter-secondary);">
                                        <div class="rounded-start-1 px-1"
                                             style="background-color: var(--lighter-secondary); color: var(--accent-color);">
                                            <?php echo abs($days) ?>
                                        </div>
                                        <div class="ms-1">DAY</div>
                                    </div>

                                    <?php
                                }
                            }
                            ?>
                        </div>

                        <!--============ task option buttons ==========-->
                        <div class="col-2 d-flex justify-content-end fw-bold task-modifyIcons">

                            <!--=========== Edit task button ========-->

                            <ion-icon class="me-1 my-auto" name="create-outline"
                                      data-mdb-toggle="tooltip"
                                      title="Modify" type="button"
                                      data-bs-toggle="modal"
                                      data-bs-target="#edit-todo-task-btn-<?php echo $catContentNo ?>-<?php echo $todo_taskNo ?>"></ion-icon>

                            <!--=========== Edit Popup ===========-->
                            <div class="modal fade"
                                 id="edit-todo-task-btn-<?php echo $catContentNo ?>-<?php echo $todo_taskNo ?>"
                                 tabindex="-1"
                                 role="dialog"
                                 aria-labelledby="exampleModalCenterTitle"
                                 aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered"
                                     role="document">
                                    <div class="modal-content">
                                        <!--=== form =====-->
                                        <form action="process/editTask.php"
                                              method="post">
                                            <div class="modal-header py-2 px-2">
                                                <div class="d-flex flex-row w-100 justify-content-between">

                                                    <div class="ms-2 my-auto fs-4 fw-bold">
                                                        <?php echo $category->category_name ?>
                                                    </div>

                                                    <!-- <div class="me-3 ms-auto my-auto px-3 py-1 bg-primary text-light fw-bold rounded-3 shadow-sm" style="font-size: 1.1rem;">New</div> -->
                                                    <!-- <div class="me-3 ms-auto my-auto px-3 py-1 bg-dark text-light fw-bold rounded-3 shadow-sm" style="font-size: 1.1rem;">Ongoing</div> -->
                                                    <div class="me-3 ms-auto my-auto px-1 py-1 fw-bold rounded-3 shadow-sm"
                                                         style="font-size: 1.3rem; color: var(--accent-color);">
                                                        Edit
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="modal-body">
                                                <div class="container w-100 ps-4 fw-bold"
                                                     style="font-size: 1.1rem;">
                                                    <!-- ====== hidden ======-->
                                                    <input type="hidden"
                                                           name="task_id"
                                                           value="<?php echo $task->task_id ?>">
                                                    <input type="hidden"
                                                           name="category_no"
                                                           value="<?php echo $catContentNo ?>">
                                                    <input type="hidden"
                                                           name="status"
                                                           value="<?php echo $task->statues ?>">

                                                    <div class="row">
                                                        <div class="col-4 text-start my-auto form-label">
                                                            Task
                                                        </div>
                                                        <div class="col ms-2 text-start text-info-emphasis">
                                                            <input type="text"
                                                                   class="form-control border-3 bg-transparent text-center"
                                                                   name="task_name"
                                                                   id=""
                                                                   value="<?php echo $task->task_name ?>"
                                                                   placeholder="Task Name"/>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-4 text-start my-auto">
                                                            Description
                                                        </div>
                                                        <div class="col text-start ms-2">
                                                                                                <textarea name="desc"
                                                                                                          class="form-control border-3 bg-transparent text-center"
                                                                                                          id=""
                                                                                                          cols="30"
                                                                                                          rows="1"
                                                                                                          placeholder="Description"><?php echo $task->description ?>
                                                                                                </textarea>
                                                        </div>
                                                    </div>
                                                    <div class="row">

                                                        <div class="col-4 text-start my-auto">
                                                            Deadline
                                                        </div>
                                                        <div class="col text-start ms-2">
                                                            <input type="datetime-local"
                                                                   class="form-control border-3 bg-transparent text-center"
                                                                   name="deadline"
                                                                   id=""
                                                                   value="<?php echo $task->deadline ?>">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-4 d-flex text-start my-auto">
                                                            <div class="my-auto">
                                                                Repeate
                                                            </div>
                                                            <div class="ms-2 my-auto form-check form-switch"
                                                                 style="font-size: 1.1rem;">
                                                                <input name="repeat"
                                                                       class="form-check-input"
                                                                       onchange="repeatOptions(<?php echo $catContentNo ?>)"
                                                                       type="checkbox"
                                                                       id="repeat-switch-<?php echo $catContentNo ?>"/>
                                                            </div>
                                                        </div>
                                                        <div class="col ms-2">
                                                            <input type="datetime-local"
                                                                   name="repeat_date"
                                                                   class="form-control border-3 bg-transparent text-center"
                                                                   style="width: 100%;"
                                                                   id="repeat-date-<?php echo $catContentNo ?>"
                                                                   disabled>
                                                        </div>

                                                    </div>
                                                    <div class="row">
                                                        <div class="col-4 me-2 ms-auto">
                                                            <select name=repeat_circle""
                                                                    id="repeat-circle-<?php echo $catContentNo ?>"
                                                                    style="width: 100%;"
                                                                    class="form-select border-3 bg-transparent text-center ms-1"
                                                                    disabled>
                                                                <option value="1"
                                                                        selected>
                                                                    Daily
                                                                </option>
                                                                <option value="2">
                                                                    Weekly
                                                                </option>
                                                                <option value="3">
                                                                    Monthly
                                                                </option>
                                                                <option value="4">
                                                                    Yearly
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>


                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button"
                                                        class="btn btn-secondary"
                                                        data-bs-dismiss="modal">
                                                    Close
                                                </button>
                                                <!-- <button type="button" class="btn btn-danger">Reject</button> -->
                                                <button type="submit"
                                                        name="submit"
                                                        class="btn fw-bold"
                                                        style="background-color: var(--secondary); color: var(--accent-color2);">
                                                    Save
                                                </button>

                                            </div>
                                        </form>
                                    </div>

                                </div>
                            </div>
                            <!--============ delete to do task =================-->
                            <ion-icon class="my-auto" name="trash-outline"
                                      data-mdb-toggle="tooltip"
                                      title="Remove"
                                      type="button" data-bs-toggle="modal"
                                      data-bs-target="#delete-todo-task-btn-<?php echo $catContentNo ?>-<?php echo $todo_taskNo ?>"></ion-icon>
                            <!--=========== delete task popup ================-->
                            <div class="modal fade"
                                 id="delete-todo-task-btn-<?php echo $catContentNo ?>-<?php echo $todo_taskNo ?>"
                                 tabindex="-1"
                                 role="dialog"
                                 aria-labelledby="exampleModalCenterTitle"
                                 aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered"
                                     role="document">
                                    <div class="modal-content">
                                        <!--=== form =====-->
                                        <form action="process/deleteTask.php"
                                              method="post">
                                            <div class="modal-header py-2 px-2">
                                                <div class="d-flex flex-row w-100 justify-content-between">

                                                    <div class="ms-2 my-auto fs-4 fw-bold">
                                                        <?php echo $task->task_name ?>
                                                    </div>

                                                    <!-- <div class="me-3 ms-auto my-auto px-3 py-1 bg-primary text-light fw-bold rounded-3 shadow-sm" style="font-size: 1.1rem;">New</div> -->
                                                    <!-- <div class="me-3 ms-auto my-auto px-3 py-1 bg-dark text-light fw-bold rounded-3 shadow-sm" style="font-size: 1.1rem;">Ongoing</div> -->
                                                    <div class="me-3 ms-auto my-auto px-1 py-1 fw-bold rounded-3 shadow-sm"
                                                         style="font-size: 1.3rem; color: var(--accent-color);">
                                                        Delete
                                                    </div>
                                                </div>

                                            </div>
                                            <!-- ============ hidden ============-->
                                            <input type="hidden" name="task_id"
                                                   value="<?php echo $task->task_id ?>">
                                            <input type="hidden"
                                                   name="category_no"
                                                   value="<?php echo $catContentNo ?>">
                                            <div class="modal-body">

                                                Do you want to Delete this task
                                                ?

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button"
                                                        class="btn btn-secondary"
                                                        data-bs-dismiss="modal">
                                                    Close
                                                </button>
                                                <!-- <button type="button" class="btn btn-danger">Reject</button> -->
                                                <button type="submit"
                                                        name="submit"
                                                        class="btn fw-bold"
                                                        style="background-color: var(--accent-color); color: var(--lighter-secondary);">
                                                    Delete
                                                </button>

                                            </div>
                                        </form>
                                    </div>

                                </div>
                            </div>

                        </div>
                        <!-- ========== collaps ========== -->
                        <?php if ($task->description !== "") {
                            ?>

                            <div id="collaps-todo-task-<?php echo $catContentNo ?>-<?php echo $todo_taskNo ?>"
                                 class="collapse mt-0 py-2 shadow rounded-bottom-4"
                                 style="background-color: var(--secondary);">
                                <div class="d-flex justify-content-between">
                                    <div class="my-auto mx-auto fw-semibold"
                                         style="font-size: 1.0rem;">
                                        <?php echo $task->description ?>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                    </div>


                    <?php
                    $todo_taskNo++;
                }

            }

            ?>


        </div>


    </div>
    <div class="card-footer text-end p-3">

    </div>
</div>

<!-- ==== Boostrap Script ==== -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
        crossorigin="anonymous"></script>


<!-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> -->

<!-- ========= Ionicons Scripts ===== -->
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>