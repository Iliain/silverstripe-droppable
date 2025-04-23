<% if $LinkedField %>
    <% if $ButtonRows %>
        <% if $UseDropdown %>
            <div class="btn-group drop">

                <select class="draggable-dropdown" data-button="dropButton_{$Top.Name}">
                    <option>{$DropdownLabel}</option>
                    <% loop $ButtonRows %>
                        <% if $Buttons %>
                            <% loop $Buttons %>
                                <option data-value="{$Value}">{$Label}</option>
                            <% end_loop %>
                        <% end_if %>
                    <% end_loop %>
                </select>

                <button type="button" id="dropButton_{$Top.Name}" class="btn btn-info drag-button dropdown-drag" data-field="{$LinkedField}" data-toggle="dropdown" draggable="true" <% if $WrapSelection %>data-wrap="{$WrapElement}"<% end_if %>>
                    Add Value
                </button>

            </div>
        <% else %>
            <ul class="drop-list">
                <% loop $ButtonRows %>
                    <% if $Buttons %>
                        <li> 
                            <% loop $Buttons %>
                                <button href="#" class="btn btn-info drag-button" draggable="true" data-value="{$Value}" data-field="{$Top.LinkedField}" <% if $Top.WrapSelection %>data-wrap="{$Top.WrapElement}"<% end_if %>>{$Label}</button>
                            <% end_loop %>
                        </li>
                    <% end_if %>
                <% end_loop %>
            </ul>
        <% end_if %>
    <% else %>
        <p>There are no buttons to display.</p>
    <% end_if %>
<% else %>
    <p>Please select a linked field.</p>
<% end_if %>