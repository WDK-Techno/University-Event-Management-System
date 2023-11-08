
<div class="container-fluid h-100">
    <div class="row h-100">
        <!-- ====== left side section ========== -->
        <div class="col-12 col-lg-8">
            <div class="m-3 border rounded w-100 shadow-sm bg-body-tertiary" style="height: 85%;">
                <div class="container p-3">
                    <div class="row">
                        <div class="col-3 d-flex justify-content-center">
                            <!-- ======= project image area ===== -->
                            <div class="d-flex flex-column">
                                <img class="img-thumbnail shadow-sm"
                                     style="width: 150px; height: 150px;"
                                     src="assets/images/profile_img/project/<?= $project->getProfileImage() ?>"
                                     alt="">
                                <form action="process/projectdashboard/saveProfileImage.php" method="post"
                                      enctype="multipart/form-data">
                                    <div class="btn fw-bold d-flex mx-4 mt-2 shadow-sm" type="button"
                                         onclick="fileUploadBtn()"
                                         style="color: var(--lighter-secondary) !important; background-color: var(--primary);">
                                        <ion-icon class="my-auto ms-auto me-1" style="font-size: 1.4rem;"
                                                  name="cloud-upload-outline"></ion-icon>
                                        <div class="my-auto ms-1 me-auto">Upload</div>
                                        <input type="file" class="form-control d-none" name="image_upload"
                                               id="image_upload" onchange="saveImgSubmit()"/>

                                    </div>
                                    <!--======= hidden ==========-->
                                    <input type="hidden" name="menuNo" value="7">
                                    <input type="hidden" name="project_id"
                                           value="<?= $project->getProjectID() ?>">
                                    <input class="d-none" type="submit" name="image_save_submit"
                                           id="image_save_submit"/>
                                </form>
                            </div>

                        </div>
                        <div class="col-9">
                            <div class="d-flex mt-2 flex-column">
                                <form action="process/projectdashboard/editProjectDetails.php"
                                      method="post">
                                    <div class="fw-bold">Project Name</div>
                                    <div class="d-flex mt-1">

                                        <input class="shadow-sm text-center form-control"
                                               name="project_name" type="text"
                                               value="<?= $project->getProjectName() ?>" required/>
                                        <!--======= hidden ==========-->
                                        <input type="hidden" name="menuNo" value="7">
                                        <input type="hidden" name="project_id"
                                               value="<?= $project->getProjectID() ?>">
                                        <button class="btn fw-bold d-flex ms-2 shadow-sm"
                                                style="width: 127px; color: var(--lighter-secondary) !important; background-color: var(--primary);"
                                                type="submit" name="submit_project_name">
                                            <ion-icon class="my-auto ms-auto me-1"
                                                      style="font-size: 1.4rem;"
                                                      name="save-outline"></ion-icon>
                                            <div class="my-auto ms-1 me-auto">Save</div>
                                        </button>

                                    </div>
                                </form>
                                <form action="process/projectdashboard/changeProjectChair.php"
                                      method="post">
                                    <div class="fw-bold mt-3">Project Chair</div>
                                    <div class="d-flex mt-1">
                                        <input class="shadow-sm text-center form-control" type="email"
                                               name="username"
                                               value="<?= $projectChair->getUsername() ?>" required/>
                                        <!--======= hidden ==========-->
                                        <input type="hidden" name="menuNo" value="7">
                                        <input type="hidden" name="project_id"
                                               value="<?= $project->getProjectID() ?>">

                                        <button class="btn fw-bold d-flex ms-2 shadow-sm"
                                                style="width: 127px; color: var(--lighter-secondary) !important; background-color: var(--primary);"
                                                type="submit" name="submit">
                                            <ion-icon class="my-auto ms-auto me-1"
                                                      style="font-size: 1.4rem;"
                                                      name="sync-outline"></ion-icon>
                                            <div class="my-auto ms-1 me-auto">Change</div>
                                        </button>
                                    </div>
                                </form>

                                <div class="mt-2 ms-3 text-center w-75" id="change-projectChair-error"
                                     style="color: var(--accent-color3)"><?= $errorMessage_settings ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <form action="process/projectdashboard/editProjectDetails.php" method="post">
                                <div class="border rounded p-3 border-secondary-subtle
                                                    bg-body-secondary shadow-sm d-flex flex-column">
                                    <div class="d-flex w-100 mx-auto">
                                        <div class="d-flex w-50 ms-5 me-auto">
                                            <div class="fw-bold w-25 my-auto">Start Date</div>
                                            <input class="form-control w-50" type="date" name="start_date"
                                                   id=""
                                                   value="<?= $project->getStartDate() ?>" required>
                                        </div>
                                        <div class="ms-auto me-5 d-flex w-50">
                                            <div class="fw-bold w-25 my-auto">End Date</div>
                                            <input class="form-control w-50" type="date" name="end_date"
                                                   id=""
                                                   value="<?= $project->getEndDate() ?>">
                                        </div>
                                    </div>
                                    <div class="d-flex mt-4 flex-column">
                                        <div class="fw-bold">Description</div>
                                        <textarea class="form-control" name="desc" id="" cols="30"
                                                  rows="9"><?= $project->getDescription() ?></textarea>
                                    </div>
                                    <!--======= hidden ==========-->
                                    <input type="hidden" name="menuNo" value="7">
                                    <input type="hidden" name="project_id"
                                           value="<?= $project->getProjectID() ?>">

                                    <button class="btn fw-bold d-flex mt-2 ms-auto me-0"
                                            style="width: 127px; color: var(--lighter-secondary) !important; background-color: var(--primary);"
                                            type="submit" name="submit_desc">
                                        <ion-icon class="my-auto ms-auto me-1" style="font-size: 1.4rem;"
                                                  name="save-outline"></ion-icon>
                                        <div class="my-auto ms-1 me-auto">Save</div>

                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ========== right side section ========== -->
        <div class="col-12 col-lg-4">
            <div class="w-100 p-0 pt-3 d-flex container d-flex flex-column">
                <!-- ======== project Team list ====== -->
                <div id="project-teams-list" class="card mx-auto col-12 col-md-8 col-lg-12 shadow-sm">
                    <div class="card-header d-flex"
                         style="background-color: var(--primary); color: var(--lighter-secondary);">
                        <div class="my-auto fw-bold" style="font-size: 1.3rem;">Project Teams</div>
                        <div class="btn fw-bold my-auto ms-auto me-2 d-flex"
                             style="color: var(--accent-color2) !important"
                             type="button" data-bs-toggle="modal"
                             data-bs-target="#add-new-project-teams">
                            <ion-icon class="my-auto" name="add-outline"></ion-icon>
                            <div class="my-auto">New</div>
                        </div>

                        <!-- =========== add new team button model =========== -->
                        <div class="modal fade"
                             id="add-new-project-teams"
                             tabindex="-1"
                             role="dialog"
                             aria-labelledby="exampleModalCenterTitle"
                             aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered"
                                 role="document">
                                <div class="modal-content">
                                    <!--=== form =====-->
                                    <form action="process/projectdashboard/addNewTeam.php"
                                          method="post">
                                        <div class="modal-header py-2 px-2"
                                             style="background-color: var(--darker-primary); color: var(--lighter-secondary);">
                                            <div class="d-flex flex-row w-100 justify-content-between">

                                                <div class="ms-2 my-auto fs-4 fw-bold">
                                                    Project Team
                                                </div>

                                                <!-- <div class="me-3 ms-auto my-auto px-3 py-1 bg-primary text-light fw-bold rounded-3 shadow-sm" style="font-size: 1.1rem;">New</div> -->
                                                <!-- <div class="me-3 ms-auto my-auto px-3 py-1 bg-dark text-light fw-bold rounded-3 shadow-sm" style="font-size: 1.1rem;">Ongoing</div> -->
                                                <div class="me-3 ms-auto my-auto px-1 py-1 fw-bold rounded-3 shadow-sm"
                                                     style="font-size: 1.3rem; color: var(--accent-color2);">
                                                    New
                                                </div>
                                            </div>

                                            <!--======= hidden ==========-->
                                            <input type="hidden" name="menuNo" value="7">
                                            <input type="hidden" name="project_id"
                                                   value="<?= $project->getProjectID() ?>">
                                        </div>

                                        <div class="modal-body"
                                             style="background-color: var(--lighter-secondary);">
                                            <div class="d-flex px-5">
                                                <input class="form-control text-center" type="text"
                                                       name="team_name" placeholder="Team Name"/>
                                            </div>
                                        </div>
                                        <div class="modal-footer"
                                             style="background-color: var(--primary);">
                                            <button type="button"
                                                    class="btn btn-secondary"
                                                    data-bs-dismiss="modal">
                                                Close
                                            </button>
                                            <button type="submit"
                                                    name="submit"
                                                    class="btn fw-bold"
                                                    style="background-color: var(--secondary); color: var(--primary);">
                                                ADD
                                            </button>

                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>

                    </div>
                    <!-- ========== project list body =========== -->
                    <div class="card-body" style="overflow-y: auto; height: 350px;">
                        <div class="container card-project-teams-list">

                            <?php
                            $projectTeamNo = 1;
                            foreach ($teamCategories as $teamCategory) {
                                ?>

                                <div class="row shadow-sm ps-2 py-3 my-2 rounded-3 fw-normal"
                                     style="font-size: 1.0rem; background-color: var(--lighter-secondary); color: var(--darker-primary);">
                                    <div class="col-9 d-flex">
                                        <div class="my-auto fs-5"><?= $teamCategory->getCategoryName() ?></div>
                                    </div>
                                    <div class="col-3" style="font-size: 1.5rem;">
                                        <div class="d-flex mx-auto card-list-option-buttons"
                                             style="font-size: 1.7rem;">
                                            <!--========== edit team category button =========-->
                                            <ion-icon class="me-2 my-auto" type="button"
                                                      data-bs-toggle="modal"
                                                      data-bs-target="#edit-project-teams-<?= $projectTeamNo ?>"
                                                      name="create-outline"></ion-icon>

                                            <!-- =========== edit team category button model =========== -->
                                            <div class="modal fade"
                                                 id="edit-project-teams-<?= $projectTeamNo ?>"
                                                 tabindex="-1"
                                                 role="dialog"
                                                 aria-labelledby="exampleModalCenterTitle"
                                                 aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered"
                                                     role="document">
                                                    <div class="modal-content">
                                                        <!--=== form =====-->
                                                        <form action="process/projectdashboard/editTeam.php"
                                                              method="post">
                                                            <div class="modal-header py-2 px-2"
                                                                 style="background-color: var(--darker-primary); color: var(--lighter-secondary);">
                                                                <div class="d-flex flex-row w-100 justify-content-between">

                                                                    <div class="ms-2 my-auto fs-4 fw-bold">
                                                                        Project Team
                                                                    </div>

                                                                    <!-- <div class="me-3 ms-auto my-auto px-3 py-1 bg-primary text-light fw-bold rounded-3 shadow-sm" style="font-size: 1.1rem;">New</div> -->
                                                                    <!-- <div class="me-3 ms-auto my-auto px-3 py-1 bg-dark text-light fw-bold rounded-3 shadow-sm" style="font-size: 1.1rem;">Ongoing</div> -->
                                                                    <div class="me-3 ms-auto my-auto px-1 py-1 fw-bold rounded-3 shadow-sm"
                                                                         style="font-size: 1.3rem; color: var(--accent-color2);">
                                                                        Edit
                                                                    </div>
                                                                </div>

                                                                <!--======= hidden ==========-->
                                                                <input type="hidden" name="menuNo"
                                                                       value="7">
                                                                <input type="hidden" name="category_id"
                                                                       value="<?= $teamCategory->getCategoryID() ?>">
                                                            </div>

                                                            <div class="modal-body"
                                                                 style="background-color: var(--lighter-secondary);">
                                                                <div class="d-flex px-5">
                                                                    <input class="form-control text-center"
                                                                           type="text"
                                                                           name="team_name"
                                                                           value="<?= $teamCategory->getCategoryName() ?>"
                                                                           placeholder="Team Name"/>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer"
                                                                 style="background-color: var(--primary);">
                                                                <button type="button"
                                                                        class="btn btn-secondary"
                                                                        data-bs-dismiss="modal">
                                                                    Close
                                                                </button>
                                                                <button type="submit"
                                                                        name="submit"
                                                                        class="btn fw-bold"
                                                                        style="background-color: var(--secondary); color: var(--primary);">
                                                                    Update
                                                                </button>

                                                            </div>
                                                        </form>
                                                    </div>

                                                </div>
                                            </div>
                                            <!--========== Delete team category button =========-->
                                            <ion-icon class="my-auto" type="button"
                                                      data-bs-toggle="modal"
                                                      data-bs-target="#delete-project-teams-<?= $projectTeamNo ?>"
                                                      name="trash-outline"></ion-icon>
                                            <!-- =========== Delete team category button model =========== -->
                                            <div class="modal fade"
                                                 id="delete-project-teams-<?= $projectTeamNo ?>"
                                                 tabindex="-1"
                                                 role="dialog"
                                                 aria-labelledby="exampleModalCenterTitle"
                                                 aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered"
                                                     role="document">
                                                    <div class="modal-content">
                                                        <!--=== form =====-->
                                                        <form action="process/projectdashboard/deleteTeam.php"
                                                              method="post">
                                                            <div class="modal-header py-2 px-2"
                                                                 style="background-color: var(--darker-primary); color: var(--lighter-secondary);">
                                                                <div class="d-flex flex-row w-100 justify-content-between">

                                                                    <div class="ms-2 my-auto fs-4 fw-bold">
                                                                        <?= $teamCategory->getCategoryName() ?>
                                                                    </div>

                                                                    <!-- <div class="me-3 ms-auto my-auto px-3 py-1 bg-primary text-light fw-bold rounded-3 shadow-sm" style="font-size: 1.1rem;">New</div> -->
                                                                    <!-- <div class="me-3 ms-auto my-auto px-3 py-1 bg-dark text-light fw-bold rounded-3 shadow-sm" style="font-size: 1.1rem;">Ongoing</div> -->
                                                                    <div class="me-3 ms-auto my-auto px-1 py-1 fw-bold rounded-3 shadow-sm"
                                                                         style="font-size: 1.3rem; color: var(--accent-color3);">
                                                                        Delete
                                                                    </div>
                                                                </div>

                                                                <!--======= hidden ==========-->
                                                                <input type="hidden" name="menuNo"
                                                                       value="7">
                                                                <input type="hidden" name="category_id"
                                                                       value="<?= $teamCategory->getCategoryID() ?>">
                                                            </div>

                                                            <div class="modal-body"
                                                                 style="background-color: var(--lighter-secondary);">
                                                                <div class="d-flex fw-normal fs-5">
                                                                    Do you want to Delete this Team ?
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer"
                                                                 style="background-color: var(--primary);">
                                                                <button type="button"
                                                                        class="btn btn-secondary"
                                                                        data-bs-dismiss="modal">
                                                                    Close
                                                                </button>
                                                                <button type="submit"
                                                                        name="submit"
                                                                        class="btn fw-bold"
                                                                        style="background-color: var(--accent-color3); color: var(--primary);">
                                                                    Delete
                                                                </button>

                                                            </div>
                                                        </form>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <?php

                                $projectTeamNo++;
                            }

                            ?>


                        </div>
                    </div>
                </div>

                <!-- =========== project chair details ======= -->
                <div class="card d-flex flex-column border rounded mt-4 shadow-sm">
                    <div class="card-header"
                         style="background-color: var(--primary); color: var(--lighter-secondary);">
                        <div class="fw-bold mx-auto" style="font-size: 1.3rem;">Project Chair</div>
                    </div>

                    <div class="d-flex card-body">
                        <img class="shadow-sm rounded-circle mx-3"
                             style="width: 80px; height: 80px; object-fit: cover;"
                             src="assets/images/profile_img/ug/<?= $projectChair->getProfileImg() ?>"
                             alt=""/>
                        <div class="d-flex ms-2 my-auto flex-column fw-bold">
                            <div class="d-flex">
                                <div class="fw-bold" style="color: var(--accent-color3);">Name</div>
                                <div class="ms-2"><?= $projectChair->getFirstName() ?> <?= $projectChair->getLastName() ?></div>
                            </div>
                            <div class="d-flex">
                                <div class="fw-bold" style="color: var(--accent-color3);">Email</div>
                                <div class="ms-2"><?= $projectChair->getUsername() ?></div>
                            </div>
                            <div class="d-flex">
                                <div class="fw-bold" style="color: var(--accent-color3);">Contact No</div>
                                <div class="ms-2"><?= $projectChair->getContactNo() ?></div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

