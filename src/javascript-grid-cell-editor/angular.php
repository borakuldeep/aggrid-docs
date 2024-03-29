<?php
$key = "Cell Editing Angular";
$pageTitle = "ag-Grid Cell Editing Angular";
$pageDescription = "You can integrate your own editors into ag-Grid that will bind into the grids navigation.";
$pageKeyboards = "ag-Grid Cell Editors Angular";
include '../documentation-main/documentation_header.php';
?>

<div>

    <h2 id="ng2CellEditing">
        <img src="../images/angular2_large.png" style="width: 60px;"/>
        Angular Cell Editing
    </h2>

    <div class="note" style="margin-bottom: 20px">
        <img align="left" src="../images/note.png" style="margin-right: 10px;" />
        <p>This section explains how to utilise ag-Grid cellEditors using Angular 2+. You should read about how
        <a href="../javascript-grid-cell-editing">Cell Editing works in ag-Grid</a> first before trying to
        understand this section.</p>
    </div>

    <p>
        It is possible to provide a Angular cellEditor for ag-Grid to use. All of the information above is
        relevant to Angular cellEditors. This section explains how to apply this logic to your Angular component.
    </p>

    <p>
        For an example of Angular cellEditing, see the
        <a href="https://github.com/ceolter/ag-grid-ng2-example">ag-grid-ng2-example</a> on Github.
    </p>

    <h3><img src="../images/angular2_large.png" style="width: 20px;"/> Specifying a Angular cellEditor</h3>

    <p>
        If you are using the ag-grid-ng2 component to create the ag-Grid instance,
        then you will have the option of additionally specifying the cellEditors
        as Angular components.
    </p>

    <pre ng-non-bindable><span class="codeComment">// create your cellEditor as a Angular component</span>
@Component({
    selector: 'editor-cell',
    template: `
        &lt;div #container class="mood" tabindex="0" (keydown)="onKeyDown($event)">
            &lt;img src="../images/smiley.png" (click)="setHappy(true)" [ngClass]="{'selected' : happy, 'default' : !happy}">
            &lt;img src="../images/smiley-sad.png" (click)="setHappy(false)" [ngClass]="{'selected' : !happy, 'default' : happy}">
        &lt;/div>
    `,
    styles: [`
        .mood {
            border-radius: 15px;
            border: 1px solid grey;
            background: #e6e6e6;
            padding: 15px;
            text-align:center;
            display:inline-block;
            outline:none
        }

        .default {
            padding-left:10px;
            padding-right:10px;
            border: 1px solid transparent;
            padding: 4px;
        }

        .selected {
            padding-left:10px;
            padding-right:10px;
            border: 1px solid lightgreen;
            padding: 4px;
        }
    `]
})
class MoodEditorComponent implements AgEditorComponent, AfterViewInit {
    private params:any;

    @ViewChild('container', {read: ViewContainerRef}) container;
    private happy:boolean = false;

    // dont use afterGuiAttached for post gui events - hook into ngAfterViewInit instead for this
    ngAfterViewInit() {
        this.container.element.nativeElement.focus();
    }

    agInit(params:any):void {
        this.params = params;
        this.setHappy(params.value === "Happy");
    }

    getValue():any {
        return this.happy ? "Happy" : "Sad";
    }

    isPopup():boolean {
        return true;
    }

    setHappy(happy:boolean):void {
        this.happy = happy;
    }

    toggleMood():void {
        this.setHappy(!this.happy);
    }

    onKeyDown(event):void {
        let key = event.which || event.keyCode;
        if (key == 37 ||  // left
            key == 39) {  // right
            this.toggleMood();
            event.stopPropagation();
        }
    }
}
<span class="codeComment">// then reference the Component in your colDef like this</span>
colDef = {
        headerName: "Mood",
        field: "mood",
        <span class="codeComment">// instead of cellEditor we use cellEditorFramework</span>
        cellEditorFramework: MoodEditorComponent,
        <span class="codeComment">// specify all the other fields as normal</span>
        editable: true,
        width: 150
    }
}</pre>

    <p>Your Angular components need to implement <code>AgEditorComponent</code>.</p>

    <p>
        By using <i>colDef.cellEditorFramework</i> (instead of <i>colDef.cellEditor</i>) the grid
        will know it's a Angular component, based on the fact that you are using the Angular version of
        ag-Grid.
    </p>


    <h3><img src="../images/angular2_large.png" style="width: 20px;"/> Angular Parameters</h3>

    <p>Your Angular components need to implement <code>AgEditorComponent</code>.
        The ag Framework expects to find the <code>agInit</code> method on the created component, and uses it to supply the cell <code>params</code>.</p>

    <h3><img src="../images/angular2_large.png" style="width: 20px;"/> Angular Methods / Lifecycle</h3>

    <p>
        All of the methods in the ICellEditor interface described above are applicable
        to the Angular Component with the following exceptions:
    <ul>
        <li><i>init()</i> is not used. Instead implement the <code>agInit</code> method (on the <code>AgRendererComponent</code> interface).</li>
        <li><i>destroy()</i> is not used. Instead implement the Angular<code>OnDestroy</code> interface (<code>ngOnDestroy</code>) for
            any cleanup you need to do.</li>
        <li><i>getGui()</i> is not used. Instead do normal Angular magic in your Component via the Angular template.</li>
        <li><i>afterGuiAttached()</i> is not used. Instead implement <code>AfterViewInit</code> (<code>ngAfterViewInit</code>) for any post Gui setup (ie to focus on an element).</li>
    </ul>

    <p>
        All of the other methods (<i>isPopup(), getValue(), isCancelBeforeStart(), isCancelAfterEnd()</i> etc)
        should be put onto your Angular component and will work as normal.
    </p>

    <h3>Example: Cell Editing using Angular Components</h3>
    <p>
        Using Angular Components in the Cell Editors, illustrating keyboard events, rendering, validation and lifecycle events.
    </p>
    <show-example example="../ng2-example/index.html?fromDocs=true&example=editor-component"
                  jsfile="../ng2-example/app/editor-component.component.ts"
                  html="../ng2-example/app/editor-component.component.html"></show-example>

</div>

<?php include '../documentation-main/documentation_footer.php';?>
