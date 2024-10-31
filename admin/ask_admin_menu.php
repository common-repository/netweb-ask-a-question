<?php if (! defined('ABSPATH')) exit; ?>
<div class="askQuestion-dashboard">
    <div class="container-fluid">
        <div class="custom-loader" style="display:none;">
            <div class="askques_loader"></div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="appHeader border-bottom">
                    <div class="heading fs-3 py-3">Ask a question</div>
                </div>
                <div class="appInfo border-bottom">
                    <div class="appLogo">
                        <img src="<?php echo esc_url(ASKAQUES_PLUGIN_PATH_URL . 'assets/images/askme-logo.png') ?>" class="img-fluid" alt="App Logo">
                        <button type="button" class="btn btn-primary position-relative me-4 custom-index asked-ques-btn" id="new_questions" data-tab="#askedQues" data-type="new_ques">
                            New Questions
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                <?php global $wpdb;

                                $query_form = ASKAQUES_QUERY_FORM_TABLE;
                                echo esc_html($wpdb->get_var("select count(*) from $query_form where created_at >= CURRENT_DATE
                                AND created_at < CURRENT_DATE + INTERVAL 1 DAY;"));
                                ?>
                            </span>
                        </button>
                    </div>
                </div>
                <div class="appBody">
                    <ul class="nav nav-tabs " id="tab1" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane">
                                <img src="<?php echo esc_url(ASKAQUES_PLUGIN_PATH_URL . 'assets/images/home-icon.png') ?>" class="tabIcon" alt="home">
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="configuration-tab" data-bs-toggle="tab" data-bs-target="#configuration-tab-pane" type="button" role="tab" aria-controls="configuration-tab-pane">
                                <img src="<?php echo esc_url(ASKAQUES_PLUGIN_PATH_URL . 'assets/images/configuration-icon.png') ?>" class="tabIcon" alt="configuration">
                                Configuration
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link position-relative asked-ques-btn" id="askedQues-tab" data-bs-toggle="tab" data-bs-target="#askedQues-tab-pane" type="button" role="tab" aria-controls="askedQues-tab-pane">
                                <img src="<?php echo esc_url(ASKAQUES_PLUGIN_PATH_URL . 'assets/images/question-icon.png') ?>" class="tabIcon" alt="question"> Asked
                                Questions

                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                    <?php global $wpdb;

                                    echo esc_html($wpdb->get_var("select count(*) from $query_form"));
                                    ?>
                                </span>
                            </button>
                        </li>
                    </ul>
                    <div class="tab-content" id="tab1Content">
                        <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab">
                            <div class="myAppTabBody">
                                <div class="row" role="tablist">
                                    <div class="col-md-3">
                                        <div class="nav serviceBox flex-and-wrap border shadow-sm">
                                            <div class="icon border-end p-3">
                                                <img class="img-fluid" src="<?php echo esc_url(ASKAQUES_PLUGIN_PATH_URL . 'assets/images/configuration-icon.png') ?>" alt="icon">
                                            </div>
                                            <div class="text p-3 card-tab-config" data-tab="#generalConfig">
                                                <div>General</div>
                                                <h4>Configuration</h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="nav serviceBox flex-and-wrap border shadow-sm">
                                            <div class="icon border-end p-3">
                                                <img class="img-fluid" src="<?php echo esc_url(ASKAQUES_PLUGIN_PATH_URL . 'assets/images/label-config.png') ?>" alt="icon">
                                            </div>
                                            <div class="text p-3 card-tab-config" data-tab="#labelConfig">
                                                <div>Label</div>
                                                <h4>Configuration</h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="serviceBox flex-and-wrap border shadow-sm">
                                            <div class="icon border-end p-3">
                                                <img class="img-fluid" src="<?php echo esc_url(ASKAQUES_PLUGIN_PATH_URL . 'assets/images/mail-config.png') ?>" alt="icon">
                                            </div>
                                            <div class="text p-3 card-tab-config" data-tab="#mailConfig">
                                                <div>Mail</div>
                                                <h4>Configuration</h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="serviceBox flex-and-wrap border shadow-sm">
                                            <div class="icon border-end p-3">
                                                <img class="img-fluid" src="<?php echo esc_url(ASKAQUES_PLUGIN_PATH_URL . 'assets/images/question-icon.png') ?>" alt="icon">
                                            </div>
                                            <div class="text p-3 card-tab-config asked-ques-btn" data-tab="#askedQues">
                                                <div>Asked</div>
                                                <h4>Questions</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="configuration-tab-pane" role="tabpanel" aria-labelledby="configuration-tab">
                            <div class="myAppTabBody">
                                <div class="innerTabs">
                                    <ul class="nav nav-tabs border shadow-sm" id="tab2" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="generalConfig-tab" data-bs-toggle="tab" data-bs-target="#generalConfig-tab-pane" type="button" role="tab" aria-controls="generalConfig-tab-pane">
                                                <div class="text-start">General</div>
                                                <h6>Configuration</h6>
                                            </button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="labelConfig-tab" data-bs-toggle="tab" data-bs-target="#labelConfig-tab-pane" type="button" role="tab" aria-controls="labelConfig-tab-pane">
                                                <div class="text-start">Label</div>
                                                <h6>Configuration</h6>
                                            </button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="mailConfig-tab" data-bs-toggle="tab" data-bs-target="#mailConfig-tab-pane" type="button" role="tab" aria-controls="mailConfig-tab-pane">
                                                <div class="text-start">Mail</div>
                                                <h6>Configuration</h6>
                                            </button>
                                        </li>
                                    </ul>
                                    <div class="tab-content" id="tab2Content">
                                        <!-- general configuration -->
                                        <?php
                                        $general_config = ASKAQUES_GENERAL_CONFIG_TABLE;

                                        $gen_config = $wpdb->get_row("select * from $general_config") ?>
                                        <div class="tab-pane fade show active" id="generalConfig-tab-pane" role="tabpanel" aria-labelledby="generalConfig-tab">
                                            <div class="myAppInnerTabBody border mt-4 p-4 shadow-sm">
                                                <form class="forms-wrapper form-submit" id="general_config" enctype="multipart/form-data" novalidate>
                                                    <input type="hidden" name="id" value="<?php echo  esc_attr($gen_config->id ?? '') ?>">
                                                    <input type="hidden" name="action" value="askaques_handle_general_config">
                                                    <div class="form-group mb-3">
                                                        <label for="email" class="mb-2">Email (On which you want to receive emails)</label>
                                                        <input id="email" type="email" name="email" class="form-control rounded-0 input-border" value="<?php echo  esc_attr($gen_config->email ?? '') ?>">
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <input type="submit" class="btn btn-primary input-border" value="Submit">
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <!-- label configuration -->
                                        <?php

                                        $label_config_table = ASKAQUES_LABEL_CONFIG_TABLE;
                                        $label_config = $wpdb->get_row("select * from $label_config_table") ?>
                                        <div class="tab-pane fade" id="labelConfig-tab-pane" role="tabpanel" aria-labelledby="labelConfig-tab">
                                            <div class="myAppInnerTabBody border mt-4 p-4 shadow-sm">
                                                <form class="forms-wrapper form-submit" id="label_config" novalidate>
                                                  
                                                    <input type="hidden" name='id' value="<?php echo  esc_attr($label_config->id ?? '') ?>">
                                                    <input type="hidden" name="action" value="askaques_handle_label_config">
                                                    <div class="form-group mb-3">
                                                        <label for="askBtnContent" class="mb-2">Ask Button
                                                            Content</label>
                                                        <input id="askBtnContent" type="text" class="form-control rounded-0 input-border" placeholder="Ask a question" name="ask_btn_content" value="<?php echo  esc_attr($label_config->ask_btn_content ?? '') ?>">
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <label for="nameLabel" class="mb-2">Name Label</label>
                                                        <input id="nameLabel" type="text" class="form-control rounded-0 input-border" placeholder="Name" name="name_label" value="<?php echo  esc_attr($label_config->name_label ?? '') ?>">
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <label for="emailLabel" class="mb-2">Email Label</label>
                                                        <input id="nameLabel" type="text" class="form-control rounded-0 input-border" placeholder="Email" name="email_label" value="<?php echo  esc_attr($label_config->email_label ?? '') ?>">
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <label for="titleLabel" class="mb-2">Title Label</label>
                                                        <input id="nameLabel" type="text" class="form-control rounded-0 input-border" placeholder="Title" name="title_label" value="<?php echo  esc_attr($label_config->title_label ?? '') ?>">
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <label for="submitBtnLabel" class="mb-2">Submit Button Content</label>
                                                        <input id="nameLabel" type="text" class="form-control rounded-0 input-border" placeholder="Submit" name="submit_btn_content" value="<?php echo  esc_attr($label_config->submit_btn_content ?? '') ?>">
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <label for="successMessageLabel" class="mb-2">Success Message Label</label>
                                                        <input id="nameLabel" type="text" class="form-control rounded-0 input-border" placeholder="Query Sent Successfully" name="success_msg_label" value="<?php echo  esc_attr($label_config->success_msg_label ?? '') ?>">
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <label for="requiredLabel" class="mb-2">Required Field Error Message Label</label>
                                                        <input id="nameLabel" type="text" class="form-control rounded-0 input-border" placeholder="All Fields are mandatory" name="field_err_msg" value="<?php echo  esc_attr($label_config->field_err_msg ?? '') ?>">
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <label for="emailValidationLabel" class="mb-2">Email Validation Message</label>
                                                        <input id="nameLabel" type="text" class="form-control rounded-0 input-border" placeholder="Invalid Email Format" name="email_validation_msg" value="<?php echo esc_attr($label_config->email_validation_msg ?? '') ?>">
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <label for="descriptionLabel" class="mb-2">Description Label</label>
                                                        <input id="nameLabel" type="text" class="form-control rounded-0 input-border" placeholder="Description" name="description_label" value="<?php echo  esc_attr($label_config->description_label ?? '') ?>">
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <label for="headingLabel" class="mb-2">Heading</label>
                                                        <input id="nameLabel" type="text" class="form-control rounded-0 input-border" placeholder="heading" name="heading" value="<?php echo esc_attr($label_config->heading ?? '') ?>">
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <label for="nameLabel" class="mb-2">Sub Heading</label>
                                                        <input id="nameLabel" type="text" class="form-control rounded-0 input-border" placeholder="Write query related to product" name="sub_heading" value="<?php echo  esc_attr($label_config->sub_heading ?? '') ?>">
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <label for="queryBtnLabel" class="mb-2">View Query Content Button</label>
                                                        <input id="nameLabel" type="text" class="form-control rounded-0 input-border" placeholder="Your Queries" name="view_query_btn" value="<?php echo  esc_attr($label_config->view_query_btn ?? '') ?>">
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <label for="cancelBtnLabel" class="mb-2">Cancel Button Content</label>
                                                        <input id="nameLabel" type="text" class="form-control rounded-0 input-border" placeholder="Cancel" name="cancel_btn_content" value="<?php echo  esc_attr($label_config->cancel_btn_content ?? '') ?>">
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <label for="replyLabel" class="mb-2">Reply Button Content</label>
                                                        <input id="nameLabel" type="text" class="form-control rounded-0 input-border" placeholder="Reply" name="reply_btn_content" value="<?php echo  esc_attr($label_config->reply_btn_content ?? '') ?>">
                                                    </div>

                                                    <div class="form-group mb-3">
                                                        <input type="submit" class="btn btn-primary input-border" value="Submit">
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <!-- mail configuration -->
                                        <?php
                                        $mail_config_table = ASKAQUES_MAIL_CONFIG_TABLE;
                                        $mail_label = $wpdb->get_row("select * from $mail_config_table"); ?>
                                        <div class="tab-pane fade" id="mailConfig-tab-pane" role="tabpanel" aria-labelledby="mailConfig-tab">
                                            <div class="myAppInnerTabBody border mt-4 p-4 shadow-sm">
                                                <form class="forms-wrapper form-submit" id="mail_config_form" novalidate>
                                                   
                                                    <input type="hidden" name='id' value="<?php echo  esc_attr($mail_label->id ?? '') ?>">
                                                    <input type="hidden" name="action" value="askaques_handle_mail_config">
                                                    <div class="form-group mb-3">
                                                        <label for="mailSubject" class="mb-2">Mail Subject
                                                            Content</label>
                                                        <input id="mailSubject" type="text" class="form-control rounded-0 input-border" placeholder="Subject" name="mail_subject" value="<?php echo  esc_attr($mail_label->mail_subject ?? '') ?>">
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <label for="mailContent" class="mb-2">Mail Content</label>
                                                        <?php
                                                        $textarea_content = wp_kses_post($mail_label->mail_content ?? '');
                                                        wp_editor($textarea_content, 'mailContent', array('media_buttons' => false, 'textarea_name' => 'mail_content', 'quicktags' => false));
                                                        ?>
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <!-- <?php submit_button('Save', 'primary'); ?> -->
                                                        <input type="submit" class="btn btn-primary input-border" value="Submit">
                                                        <input type="button" id="btn-test-mail" class="btn btn-primary input-border" value="Send Test Mail">
                                                        <button type="reset" class="btn btn-primary" value="Reset">Reset</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="askedQues-tab-pane" role="tabpanel" aria-labelledby="askedQues-tab">
                            <div class="myAppTabBody asked-ques">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="queryViewModal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="queryViewModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="queryViewModalLabel">Query Details</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="queryWrapper mb-3">
                    <div class="fs-5 mb-3">Basic Details</div>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th>Query ID </th>
                                <td id="query_id"></td>
                            </tr>
                            <tr>
                                <th>Customer Name </th>
                                <td id="customer"></td>
                            </tr>

                            <tr>
                                <th>Query Title </th>
                                <td id="title"></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="queryWrapper">
                    <div class="fs-5 mb-3">Whole Conversation</div>
                    <select class="form-select" name="status" aria-label="Default select example" id="query_status">
                        <option selected disabled>Select status</option>
                        <?php global $wpdb;
                        $query_status = ASKAQUES_QUERY_STATUS_TABLE;
                        $statuses = $wpdb->get_results("select * from $query_status");
                        foreach ($statuses as $status) : ?>
                            <option value=<?php echo esc_attr($status->id) ?>><?php echo esc_html($status->status) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <div class="query-description border rounded p-2 mt-1"></div>
                    <div class="wholeChat mt-2">

                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-start">
                <form class="form-submit" data-form-type="modal">
                    <input type="hidden" name='query_id'>
                    <input type="hidden" name='action' value="askaques_handle_query_reply">
                    <textarea placeholder="Write Some..." class="form-control mb-2" cols='80' name='reply'></textarea>
                    <input type="submit" class="btn btn-primary" value="<?php echo esc_attr($label_config->reply_btn_content) ?? 'Reply' ?>">
                </form>
            </div>
        </div>
    </div>
</div>