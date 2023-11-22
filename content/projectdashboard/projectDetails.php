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
                            </div>

                        </div>
                        <div class="col-9">
                            <div class="d-flex mt-2 flex-column">
<!--                                <div class="fw-bold">Project Name</div>-->
                                <div class="d-flex mt-1 fs-1 fw-bold" style="color: var(--primary)">
                                    <?= $project->getProjectName() ?>
                                </div>
                                <div class="d-flex fs-4 fw-bold" style="color: var(--darker-primary)"><?= $club->getClubName() ?></div>
                                <div class="d-flex mt-2 ms-0">
                                    <div class="d-flex ms-0 rounded p-1" style="background-color: var(--primary)">
                                        <div class="fw-bold my-auto ps-1 pe-1" style="color: var(--lighter-secondary)">Start Date</div>
                                        <div class="my-auto ms-1 ps-1 pe-1 rounded-end fw-bolder bg-body-tertiary"><?= $project->getStartDate() ?></div>
                                    </div>
                                    <div class="d-flex ms-5 rounded p-1" style="background-color: var(--primary)">
                                        <div class="fw-bold my-auto ps-1 pe-1" style="color: var(--lighter-secondary)">End Date</div>
                                        <div class="my-auto ms-1 ps-1 pe-1 rounded-end fw-bolder bg-body-tertiary"><?= $project->getEndDate() ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12">

                            <div class="border rounded p-3 border-secondary-subtle
                                                    bg-body-secondary shadow-sm d-flex flex-column">

                                <div class="d-flex mt-0 flex-column" style="height: 200px">
                                    <div class="fw-bold">Project Description</div>
                                    <div class="mt-2 mb-2 p-1 rounded" style="height: 100%"><?= $project->getDescription() ?></div>
                                </div>

                            </div>

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