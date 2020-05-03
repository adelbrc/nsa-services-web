<div class="dataContainer">
    <h3 class="text-center">Doublons</h3>
    <p style="color: red"><b>Sélectionnez celui que vous souhaitez conserver</b></p>
    <p id="handle_status" style="color: green"></p>
    <div class="row">




<!-- <div class="container bg-secondary border duplicate-box">
            <div class="container d-flex align-items-center justify-content-between">
            <p>#ID</p>
            <p>Nom</p>
            <p>Prenom</p>
            <p>Choix</p>
        </div>
    </div> -->


    <?php

    $queryDuplicates = $conn->query("SELECT email, COUNT(*) occurrences FROM partner GROUP BY email HAVING COUNT(*) > 1;");
    $res = $queryDuplicates->fetchAll();

    // var_dump($res);

    foreach($res as $dup): ?>

        <!-- UNIT -->
        <div class="container border duplicate-box">



        <?php

            $queryDup = $conn->prepare("SELECT * FROM partner WHERE email = ?");
            $queryDup->execute([$dup["email"]]);

            $random = random_int(100, 999);
            while (($dup_unit = $queryDup->fetch())): ?>
                <div class="container d-flex align-items-center justify-content-between">
                    <p><?= $dup_unit["add_date"] ?></p>
                    <p><?= $dup_unit["partner_id"] ?></p>
                    <p><?= $dup_unit["lastname"] ?></p>
                    <p><?= $dup_unit["email"] ?></p>
                    <input type="checkbox" style="width: 20px;height: 20px;" data-partner-id="<?= $dup_unit["partner_id"] ?>" class="cb_doublon checkbox_<?= $random . substr($dup["email"], 0, 2) ?>" data-cb-id="checkbox_<?= $random . substr($dup["email"], 0, 2) ?>" onclick="selectDoublon(this)">
                </div>
            <?php endwhile; ?>

            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_<?php echo $random . substr($dup["email"], 0, 2) ?>">
                Voir comparaison
            </button>

            <button type="button" class="btn btn-success" onclick="validate_doublon('<?= $random . substr($dup["email"], 0, 2) ?>', '<?= $dup["email"] ?>')">
                Valider
            </button>
            <p id="error_<?= $random . substr($dup["email"], 0, 2) ?>"></p>

            <!-- Modal -->
            <div class="modal fade" id="modal_<?php echo $random . substr($dup["email"], 0, 2) ?>" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content" style="width: 700px">
                        <div class="modal-header">
                            <h5 class="modal-title">Modal </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body container-fluid d-flex justify-content-between">

                            <?php

                            $queryDupModal = $conn->prepare("SELECT * FROM partner WHERE email = ?");
                            $queryDupModal->execute([$dup["email"]]);
                            $resDupModal = $queryDupModal->fetchAll();

                            foreach ($resDupModal as $resModal): ?>

                                <div class="" style="flex: 1">
                                    <p>Partner n° <?= $resModal["partner_id"] ?></p>
                                    <p><b>Inséré le : </b><?= $resModal["add_date"] ?></p>
                                    <p><?= $resModal["firstname"] . " " . $resModal["lastname"] ?></p>
                                    <p><b>Email : </b><?= $resModal["email"] ?></p>
                                    <p><b>Phone : </b><?= $resModal["phone"] ?></p>
                                    <p><b>Entreprise : </b><?= $resModal["corporation_name"] ?></p>
                                    <p><b>Adresse : </b><?= $resModal["address"] ?></p>
                                    <p><?= $resModal["city"] ?></p>
                                    <p><b>Disponible de : </b><?= $resModal["disponibility_begin"] ?></p>
                                    <p><b>au : </b><?= $resModal["disponibility_end"] ?></p>
                                    <img src="<?= $resModal["qrcode"] ?>" alt="" width="100" height="100" />
                                    <p></p>
                                </div>


                            <?php endforeach; ?>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>

</div>
