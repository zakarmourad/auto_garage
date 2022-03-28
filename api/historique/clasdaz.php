 <section class="first-sec container">
                                <div class="row dolr">
                                    <div class="col">
                                        <label>Client</label>

                                    </div>
                                    <div class="col">
                                        <input type="text" class="darpi" placeholder="Client"
                                            value="<?php echo $historiques["cliname"] ; ?>" disabled>
                                    </div>
                                </div>


                                <div class="row dolr">
                                    <div class="col">
                                        <label>N°Chassis</label>
                                    </div>
                                    <div class="col">
                                        <input type="text" class="darpi" placeholder="N°Chassis" disabled
                                            value="<?php echo $historiques["chassis"] ; ?>">
                                    </div>
                                </div>
                                <div class="row dolr">
                                    <div class="col">
                                        <label>Marque</label>
                                    </div>
                                    <div class="col">
                                        <input type="text" class="darpi" placeholder="Marque" disabled
                                            value="<?php echo $historiques["mark"] ; ?>">
                                    </div>
                                </div>
                                <div class="row dolr">
                                    <div class="col">
                                        <label>Model</label>
                                    </div>
                                    <div class="col">
                                        <input type="text" class="darpi" placeholder="Model" disabled
                                            value="<?php echo $historiques["model"] ; ?>">

                                    </div>
                                </div>
                                <div class="row dolr">
                                    <div class="col">
                                        <label>Immatricule</label>

                                    </div>
                                    <div class="col">
                                       
                                    </div>
                                </div>



                                <div class="row dolr">
                                    <div class="col">
                                        <label>Kilométrage</label>
                                    </div>
                                    <div class="col">
                                        <span style="display:inline"><input type="text" class="darpi"
                                                placeholder="Kilométrage" disabled
                                                value="<?php echo $historiques["kilometrage"] ; ?>"> km</span>

                                    </div>
                                </div>
                                <div class="row dolr">
                                    <div class="col">
                                        <label>Niveau </label>
                                    </div>
                                    <div class="col">
                                        <input type="text" class="darpi" placeholder="Niveau" disabled
                                            value="<?php echo $historiques["niveau"] ; ?>">

                                    </div>
                                </div>

                            </section>
                            <section class="second-sec">
                                <div><span>Etat de véhicule sans démontage</span></div>
                                
                                <div><output id="list">

                                <?php 
                                  for($x=0; $x<count($historiques['images']); $x++){
                                        echo " <img class='thumb' src='../voiture/uploads/".$historiques["images"][$x]."' alt='image du voiture' />  ";
                                  }
                                ?>
                                </output></div>
                            </section>
                            <section class="third-sec">
                                <div><span>Véhicule réparé par</span></div>
                                <input type="text" placeholder=" Technicien 1" disabled
                                    value="<?php if(isset($historiques["t1"])){ echo $historiques["t1"];}   ?>">
                                <input type="text" placeholder=" Technicien 2" disabled
                                    value="<?php if(isset($historiques["t2"])){ echo $historiques["t2"];} ?>">
                                <input type="text" placeholder=" Technicien 3" disabled
                                    value="<?php if(isset($historiques["t3"])){ echo $historiques["t3"];} ?>">
                            </section>
                            <section class="sixth-sec">
                                <button type="button" class="btn btn-outline-warning  btn-block" id="next-1">Demande de
                                    Client <span style="font-size:2Opx"><b>==></b></span></button>

                            </section>