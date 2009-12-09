<?php
// set this to the number of inner and outer positions
$new_count = 5;
// define old positions
$old_module_positions = array('splitleft', 'topleft', 'left', 'bottomleft', 'splitright', 'topright', 'right', 'bottomright');
$new_module_positions = array();

for($i=1;$i<=$new_count;$i++){ $new_module_positions[] = 'inner'.$i; }
for($i=1;$i<=$new_count;$i++){ $new_module_positions[] = 'outer'.$i; }

?>

<div id="module-migrator">
	<h2>Sidebar Module Migrator</h2>
	
	<div id="mp-source" class="select-cont">
		<div class="heading">
			<label for="old-positions">Source:</label>
			<select name="old-positions" id="old-positions">
				<option value="">Select a position</option>
				<?php
				foreach($old_module_positions as $omp){
					echo '<option value="'.$omp.'">'.$omp.'</option>';
				}
				?>
			</select>
		</div>
		<div class="contents">
			<select name="old-modules[]" id="old-modules" multiple="multiple" class="multiselect">
			</select>
			<ul id="new-add-multiselect">
				
			</ul>
			<p id="new-add-all"><a href="#" class="ms-add-all">Add all</a></p
		</div>
	</div>
	
	<div id="mp-dest" class="select-cont">
		<div class="heading">
			<label for="new-positions">Destination:</label>
			<select name="new-positions" id="new-positions" disabled="disabled">
				<option value="">Select a position</option>
				<?php
				foreach($new_module_positions as $nmp){
					echo '<option value="'.$nmp.'">'.$nmp.'</option>';
				}
				?>
			</select>
		</div>
		<div class="contents">
			<div class="tooltip">
				<p>Please select a <strong>destination</strong> module position from the dropdown above :)</p>
			</div>
			<select name="new-modules[]" id="new-modules" multiple="multiple" class="multiselect">
			</select>
			<ul id="new-remove-multiselect">
				
			</ul>
			<p id="new-remove-all"><a href="#" class="ms-remove-all">Remove all</a></p>
		</div>
	</div>
	
	<div id="migrate-submit">
		<a href="#" class="btn-link">Migrate Modules</a>
	</div>
	
	<div id="migrate-reset">
		<h2>Reset Module Positions</h2>
		<ul>
			<li class="migrate-outer">
				<a href="#" class="btn-link" action="outer">Reset all Outer Positions to Left Position</a>
				<p>This will reset all the Outer Positions (Outer 1 - Outer 5) back to the Left position</p>
			</li>
			<li class="migrate-inner">
				<a href="#" class="btn-link" action="inner">Reset all Inner Positions to Right Position</a>
				<p>This will reset all the Inner Positions (Inner 1 - Inner 5) back to the Right position</p>
			</li>
		</ul>
	</div>

</div>
