<?php

/**
 * Class #MODULE#_#MODEL_CONTROLLER_CLASS#Controller
 */
class #MODULE#_#MODEL_CONTROLLER_CLASS#Controller extends Application_Controller_Default
{

    /**
     * Load form edit
     */
    public function loadformAction()
    {
        $#PRIMARY_KEY# = $this->getRequest()->getParam("#PRIMARY_KEY#");

        $#MODEL# = new #MODULE#_Model_#MODEL_CAMEL#();
        $#MODEL#->find($#PRIMARY_KEY#);
        if ($#MODEL#->getId()) {
            $form = new #MODULE#_Form_#MODEL_CAMEL#();

            $form->populate($#MODEL#->getData());
            $form->setValueId($this->getCurrentOptionValue()->getId());
            $form->removeNav("nav-#FORM_ID#");
            $form->addNav("edit-nav-#FORM_ID#", "Save", false);
            $form->set#PRIMARY_KEY_CAMEL#($#MODEL#->getId());

            $payload = [
                'success' => true,
                'form' => $form->render(),
                'message' => __('Success.'),
            ];
        } else {
            // Do whatever you need when form is not valid!
            $payload = [
                'error' => true,
                'message' => __('The #HUMAN_MODEL# you are trying to edit doesn\'t exists.'),
            ];
        }

        $this->_sendJson($payload);
    }

    /**
     * Create/Edit #HUMAN_MODEL#
     *
     * @throws exception
     */
    public function editpostAction()
    {
        $values = $this->getRequest()->getPost();

        $form = new #MODULE#_Form_#MODEL_CAMEL#();
        if ($form->isValid($values)) {
            /** Do whatever you need when form is valid */
            $#MODEL# = new #MODULE#_Model_#MODEL_CAMEL#();
            $#MODEL#->addData($values);
            $#MODEL#->save();

            $payload = [
                'success' => true,
                'message' => __('Success.'),
            ];
        } else {
            /** Do whatever you need when form is not valid */
            $payload = [
                'error' => true,
                'message' => $form->getTextErrors(),
                'errors' => $form->getTextErrors(true),
            ];
        }

        $this->_sendJson($payload);
    }

    /**
     * Delete #HUMAN_MODEL#
     */
    public function deletepostAction()
    {
        $values = $this->getRequest()->getPost();

        $form = new #MODULE#_Form_#MODEL_CAMEL#_Delete();
        if ($form->isValid($values)) {
            $#MODEL# = new #MODULE#_Model_#MODEL_CAMEL#();
            $#MODEL#->find($values["#PRIMARY_KEY#"]);
            $#MODEL#->delete();

            $payload = [
                'success' => true,
                'success_message' => __('#HUMAN_MODEL# successfully deleted.'),
                'message_loader' => 0,
                'message_button' => 0,
                'message_timeout' => 2
            ];
        } else {
            $payload = [
                'error' => 1,
                'message' => $form->getTextErrors(),
                'errors' => $form->getTextErrors(true),
            ];
        }

        $this->_sendJson($payload);
    }

}