<?php
$key = "Filtering React";
$pageTitle = "ag-Grid Filtering React";
$pageDescription = "ag-Grid Filtering React";
$pageKeyboards = "ag-Grid Filtering React";
include '../documentation-main/documentation_header.php';
?>

<div>

    <h2 id="reactFiltering">
        <img src="../images/react.png" style="width: 60px"/>
        React Filtering
    </h2>

    <div class="note" style="margin-bottom: 20px">
        <img align="left" src="../images/note.png" style="margin-right: 10px;" />
        <p>This section explains how to create an ag-Grid Filter using React. You should read about how
        <a href="../javascript-grid-filtering">Filters work in ag-Grid</a> first before trying to
        understand this section.</p>
    </div>

    <p>
        It is possible to provide a React filter for ag-Grid to use. All of the information above is
        relevant to React filters. This section explains how to apply this logic to your React component.
    </p>

    <p>
        For examples on React filtering, see the
        <a href="https://github.com/ceolter/ag-grid-react-example">ag-grid-react-example</a> on Github.
        In the example, 'Skills' , 'DOB' and 'Proficiency' columns use React filters.</p>
    </p>

    <h3><img src="../images/react_large.png" style="width: 20px;"/> Specifying a React Filter</h3>

    <p>
        If you are using the ag-grid-react component to create the ag-Grid instance,
        then you will have the option of additionally specifying the filters
        as React components.
    </p>

    <pre><span class="codeComment">// create your filter as a React component</span>
class NameFilter extends React.Component {

    <span class="codeComment">// put in render logic, build a nice gui in React</span>
    render() {
        return &lt;span>My Nice Little Filter Gui&lt;/span>;
    }

    <span class="codeComment">// implement the other Filter callbacks</span>
    isFilterActive(params) {
        <span class="codeComment">// do some filter logic</span>
        return filterPass ? true : false;
    }

    <span class="codeComment">// etc etc, more logic, but leaving out for now</span>
}

<span class="codeComment">// then reference the Component in your colDef like this</span>
colDef = {

    <span class="codeComment">// instead of cellRenderer we use cellRendererFramework</span>
    filterFramework: NameFilter

    <span class="codeComment">// specify all the other fields as normal</span>
    headerName: 'Name',
    field: 'firstName',
    ...
}</pre>

    <p>
        By using <i>colDef.filterFramework</i> (instead of <i>colDef.filter</i>) the grid
        will know it's a React component, based on the fact that you are using the React version of
        ag-Grid.
    </p>


    <h3><img src="../images/react_large.png" style="width: 20px;"/> React Props</h3>

    <p>
        The React component will get the 'filter Params' as described above as it's React Props.
        Therefore you can access all the parameters as React Props.

    <pre><span class="codeComment">// React filter Component</span>
class NameFilter extends React.Component {

    <span class="codeComment">// did you know that React passes props to your component constructor??</span>
    constructor(props) {
        super(props);
        <span class="codeComment">// from here you can access any of the props!</span>
        console.log('The field for this filter is ' + props.colDef.field);
    }

    <span class="codeComment">// maybe your filter has a button in it, and when it gets clicked...</span>
    onButtonWasPressed() {
        <span class="codeComment">// all the methods in the props can be called</span>
        this.props.filterChangedCallback();
    }
}</pre>
    </p>

    <h3><img src="../images/react_large.png" style="width: 20px;"/> React Methods / Lifecycle</h3>

    <p>
        All of the methods in the IFilter interface described above are applicable
        to the React Component with the following exceptions:
    <ul>
        <li><i>init()</i> is not used. Instead use the React props passed to your Component.</li>
        <li><i>destroy()</i> is not used. Instead use the React <i>componentWillUnmount()</i> method for
            any cleanup you need to do.</li>
        <li><i>getGui()</i> is not used. Instead do normal React magic in your <i>render()</i> method..</li>
    </ul>

    <p>
        After that, all the other methods (<i>onNewRowsLoaded(), getModel(), setModel()</i> etc) behave the
        same so put them directly onto your React Component.
    </p>

    <h3><img src="../images/react_large.png" style="width: 20px;"/> Accessing the React Component Instance</h3>

    <p>
        ag-Grid allows you to get a reference to the filter instances via the <i>api.getFilterInstance(colKey)</i>
        method. If your component is a React component, then this will give you a reference to the ag-Grid's
        Component which wraps your React Component. Just like Russian Dolls. To get to the wrapped React instance
        of your component, use the <i>getFrameworkComponentInstance()</i> method as follows:
        <pre><span class="codeComment">// lets assume a React component as follows</span>
class NameFilter extends React.Component {

    ... <span class="codeComment">// standard filter methods hidden</span>

    <span class="codeComment">// put a custom method on the filter</span>
    myMethod() {
        <span class="codeComment">// does something</span>
    }
}

<span class="codeComment">// then in your app, if you want to execute myMethod()...</span>
laterOnInYourApplicationSomewhere() {

    <span class="codeComment">// get reference to the ag-Grid Filter component</span>
    var agGridFilter = api.getFilterInstance('name'); <span class="codeComment">// assume filter on name column</span>

    <span class="codeComment">// get React instance from the ag-Grid instance</span>
    var reactFilterInstance = agGridFilter.getFrameworkComponentInstance();

    <span class="codeComment">// now were sucking diesel!!!</span>
    reactFilterInstance.myMethod();
}</pre>
    </p>

</div>

<?php include '../documentation-main/documentation_footer.php';?>