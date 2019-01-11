<?
	class Tabs implements AtlasBlock {
		public function register() {

		}
		public function fields() {
			acf_add_local_field_group(array(
				'key' => 'group_1',
				'title' => 'My Group',
				'fields' => array (
					array (
						'key' => 'field_1',
						'label' => 'Sub Title',
						'name' => 'sub_title',
						'type' => 'text',
					)
				),
				'location' => array (
					array (
						array (
							'param' => 'post_type',
							'operator' => '==',
							'value' => 'post',
						),
					),
				),
			));
		}
		public function render() {

		}
	}
?>