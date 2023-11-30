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

            <button type="button" id="dropButton_{$Top.Name}" class="btn btn-info drag-button dropdown-drag" data-toggle="dropdown" draggable="true">
                Add Value
            </button>

        </div>
    <% else %>
        <% loop $ButtonRows %>
            <% if $Buttons %>
                <p> 
                    <% loop $Buttons %>
                        <a href="#" class="btn btn-info drag-button" draggable="true" data-value="{$Value}">{$Label}</a>
                    <% end_loop %>
                </p>
            <% end_if %>
        <% end_loop %>
    <% end_if %>
<% end_if %>

<textarea {$AttributesHTML}>{$ValueEntities.RAW}</textarea>