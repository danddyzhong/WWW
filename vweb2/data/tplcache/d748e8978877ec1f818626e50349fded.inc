<li class="dropDown"> <a href="{dede:field name='typeurl'/}" class="currentLink B"> {dede:field name='typename'/} </a>
            <ul class="dropDown-list">
              {dede:channel type='son' noself='yes'}
              <li> <a class="newLink font16" href="[field:typeurl/]"> [field:typename/] </a> </li>
              {/dede:channel}
            </ul>
          </li>