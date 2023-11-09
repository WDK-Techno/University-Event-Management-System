<?php
require_once "classes/User.php";
require_once "classes/TeamCategory.php";
use classes\Undergraduate;
use classes\TeamCategory;
?>

<div class="container-fluid">
    <div class="row d-flex">
        <div class="col-11 mx-auto">

            <!-- ======= add member button ======== -->
            <div class="d-flex mt-3 mb-2">
                <div class="btn fw-bold my-auto me-0 ms-auto d-flex"
                     style="color: var(--lighter-secondary) !important; background-color: var(--primary);"
                     type="button" data-bs-toggle="modal"
                     data-bs-target="#add-new-team-member">
                    <ion-icon class="my-auto" name="add-outline"></ion-icon>
                    <div class="my-auto">Member</div>
                </div>
            </div>

            <!-- ========= add member button model ========== -->
            <div class="modal fade"
                 id="add-new-team-member"
                 tabindex="-1"
                 role="dialog"
                 aria-labelledby="exampleModalCenterTitle"
                 aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered"
                     role="document">
                    <div class="modal-content">
                        <!--=== form =====-->
                        <form>
                            <div class="modal-header py-2 px-2"
                                 style="background-color: var(--darker-primary); color: var(--lighter-secondary);">
                                <div class="d-flex flex-row w-100 justify-content-between">

                                    <div class="ms-2 my-auto fs-4 fw-bold">
                                        Team Member
                                    </div>

                                    <!-- <div class="me-3 ms-auto my-auto px-3 py-1 bg-primary text-light fw-bold rounded-3 shadow-sm" style="font-size: 1.1rem;">New</div> -->
                                    <!-- <div class="me-3 ms-auto my-auto px-3 py-1 bg-dark text-light fw-bold rounded-3 shadow-sm" style="font-size: 1.1rem;">Ongoing</div> -->
                                    <div class="me-3 ms-auto my-auto px-1 py-1 fw-bold rounded-3 shadow-sm"
                                         style="font-size: 1.3rem; color: var(--accent-color2);">
                                        New
                                    </div>
                                </div>

                                <!--======= hidden ==========-->
                                <input type="hidden" name="menuNo" value="2">
                            </div>

                            <div class="modal-body"
                                 style="background-color: var(--lighter-secondary);">
                                <!-- ====== input username ====== -->
                                <div class="d-flex px-5">
                                    <input class="form-control text-center" type="email"
                                           name="username" id="add-member-username-input"
                                           placeholder="Email" required/>
                                </div>
                                <!-- ===== select team ======= -->
                                <div class="d-flex mt-2 px-5">
                                    <select id="add-member-team-select" class="form-select ms-auto me-0"
                                            style="width: 50%;"
                                            name="project_team_id" id="" required>
                                        <option class="text-center" value="" selected>-- Select Team --
                                        </option>
                                        <?php
                                        foreach ($teamCategories as $teamCategory) {
                                            ?>
                                            <option value="<?= $teamCategory->getCategoryID() ?>"><?= $teamCategory->getCategoryName() ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="mt-2 text-center" id="add-member-team-error"
                                     style="color: var(--accent-color3)"></div>

                            </div>
                            <div class="modal-footer" style="background-color: var(--primary);">
                                <button type="button"
                                        class="btn btn-secondary"
                                        data-bs-dismiss="modal">
                                    Close
                                </button>
                                <button type="button"
                                        onclick="addMemberToProject()"
                                        class="btn fw-bold"
                                        style="background-color: var(--secondary); color: var(--primary);">
                                    ADD
                                </button>

                            </div>
                        </form>
                    </div>

                </div>
            </div>


            <!-- ========== member table ============ -->
            <div class="card" style="">
                <div class="card-header team-member-table pb-0"
                     style="background-color: var(--darker-primary); color: var(--lighter-secondary);">

                    <div class="row p-0 fw-bold">
                        <div class="col-1"></div>
                        <div class="col-3 text-center py-2 rounded-top-3"
                             style="background-color: var(--primary);">Name
                        </div>
                        <div class="col-3 text-center py-2 rounded-top-3"
                             style="background-color: var(--lighter-secondary); color: var(--darker-primary);">
                            Email
                        </div>
                        <div class="col-2 text-center py-2 rounded-top-3"
                             style="background-color: var(--primary);">Contact No
                        </div>
                        <div class="col-2 text-center py-2 rounded-top-3"
                             style="background-color: var(--lighter-secondary); color: var(--darker-primary);">
                            Team
                        </div>
                        <div class="col-1">

                        </div>
                    </div>

                </div>

                <div class="card-body pt-0 bg-dark-subtle scrollable-div Flipped"
                     style="background-color: var(--secondary);">
                    <div class="container p-0 scrollable-div-inside">

                        <?php
                        $teamMemberNo = 1;
                        foreach ($teamMembers as $teamMember) {

                            $projectMember = new Undergraduate(null, null, null, null, null, null);
                            $projectMember->setUserId($teamMember->getUgID());
                            $projectMember->loadDataFromUserID($con);

                            $projectMemberTeam = new TeamCategory($teamMember->getCategoryID(), null, null, null);
                            $projectMemberTeam->loadDataByTeamID($con);

                            ?>
                            <div class="row mb-2 shadow-sm set-border" style="height: 50px;">
                                <div class="col-1 d-flex tabel-column-type-2">
                                    <div class="my-auto">
                                        <img class="rounded-circle"
                                             style="width: 40px; height: 40px; object-fit: cover;"
                                             src="assets/images/profile_img/ug/<?= $projectMember->getProfileImg() ?>"
                                             alt="">
                                    </div>
                                </div>
                                <div class="col-3 tabel-column-type-1 d-flex">
                                    <div class="my-auto"><?= $projectMember->getFirstName() ?> <?= $projectMember->getLastName() ?></div>
                                </div>
                                <div class="col-3 d-flex tabel-column-type-2">
                                    <div class="my-auto mx-auto"><?= $projectMember->getUsername() ?></div>
                                </div>
                                <div class="col-2 d-flex tabel-column-type-1">
                                    <div class="my-auto mx-auto"><?= $projectMember->getContactNo() ?></div>
                                </div>
                                <div class="col-2 d-flex tabel-column-type-2">
                                    <div class="my-auto mx-auto"><?= $projectMemberTeam->getCategoryName() ?></div>
                                </div>
                                <div class="col-1 tabel-column-type-1 d-flex">
                                    <div class="d-flex my-auto mx-auto" style="font-size: 1.5rem;">

                                        <!--========== Delete team Member button =========-->
                                        <ion-icon class="my-auto" type="button"
                                                  data-bs-toggle="modal"
                                                  data-bs-target="#delete-project-member-<?= $teamMemberNo ?>"
                                                  name="trash-outline"></ion-icon>
                                    </div>

                                    <!-- =========== Delete team Member button model =========== -->
                                    <div class="modal fade"
                                         id="delete-project-member-<?= $teamMemberNo ?>"
                                         tabindex="-1"
                                         role="dialog"
                                         aria-labelledby="exampleModalCenterTitle"
                                         aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered"
                                             role="document">
                                            <div class="modal-content">
                                                <!--=== form =====-->
                                                <form action="process/projectdashboard/deleteTeamMember.php"
                                                      method="post">
                                                    <div class="modal-header py-2 px-2"
                                                         style="background-color: var(--darker-primary); color: var(--lighter-secondary);">
                                                        <div class="d-flex flex-row w-100 justify-content-between">

                                                            <div class="ms-2 my-auto fs-4 fw-bold">Team
                                                                Member
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
                                                               value="2">
                                                        <input type="hidden" name="ug_id"
                                                               value="<?= $projectMember->getUserId() ?>">
                                                        <input type="hidden" name="cat_id"
                                                               value="<?= $projectMemberTeam->getCategoryID() ?>">
                                                    </div>

                                                    <div class="modal-body"
                                                         style="background-color: var(--lighter-secondary);">
                                                        <div class="d-flex flex-column fw-normal fs-5">
                                                            <div class="fw-bold">
                                                                Do you want to Delete this Team Member ?
                                                            </div>
                                                            <div class="fw-bold"
                                                                 style="color: var(--primary); font-size: 1.1rem;">
                                                                <?= $projectMember->getFirstName() ?> <?= $projectMember->getLastName() ?>
                                                            </div>
                                                            <div class="fw-bold"
                                                                 style="color: var(--accent-color); font-size: 1.1rem;">
                                                                <?= $projectMemberTeam->getCategoryName() ?>
                                                            </div>

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

                            <?php
                            $teamMemberNo++;
                        }
                        ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
