<?php
class NotesController extends AppController {

	var $name = 'Notes';
	var $components = array('Session');

	function index() {
		$this->Note->recursive = 0;
		$this->set('notes', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid note', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('note', $this->Note->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Note->create();
			if ($this->Note->save($this->data)) {
				$this->Session->setFlash(__('The note has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The note could not be saved. Please, try again.', true));
			}
		}
		$users = $this->Note->User->find('list');
		$this->set(compact('users'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid note', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Note->save($this->data)) {
				$this->Session->setFlash(__('The note has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The note could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Note->read(null, $id);
		}
		$users = $this->Note->User->find('list');
		$this->set(compact('users'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for note', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Note->delete($id)) {
			$this->Session->setFlash(__('Note deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Note was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
