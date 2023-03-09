import React from "react";
import { Tab, Tabs, TabList, TabPanel } from 'react-tabs';
import 'react-tabs/style/react-tabs.css';
import JavaScript from "./JavaScript";
import CSS from './CSS'
import HTML from './HTML'


function App() {
  return (
    <Tabs>
      <TabList>
        <Tab title="JavaScript">JavaScript</Tab>
        <Tab>CSS</Tab>
        <Tab>HTML</Tab>
      </TabList>

      <TabPanel><JavaScript/></TabPanel>
      <TabPanel><CSS/></TabPanel>
      <TabPanel><HTML/></TabPanel>
    </Tabs>
  );
}
export default App;
