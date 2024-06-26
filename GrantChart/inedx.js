
const dp = new DayPilot.Gantt("dp");
dp.startDate = new DayPilot.Date("2023-08-05");
dp.days = 100;
dp.linkBottomMargin = 5;
dp.rowCreateHandling = 'Enabled';
dp.linkCreateHandling = "Disabled";
dp.rowClickHandling = "Disabled";
dp.rowHeaderScrolling = true;

dp.columns = [
  {name: "Name", display: "text", maxAutoWidth: 100},
  {name: "Duration", width: 70}
];
dp.height = 700;
dp.rowHeaderWidth = 270;
dp.onBeforeRowHeaderRender = (args) => {
  args.row.columns[1].html = args.task.duration().toString("d") + " days";
  args.row.areas = [
    {
      right: 3,
      top: 3,
      width: 30,
      height: 16,
      style: "cursor: pointer; box-sizing: border-box; background: white; border: 1px solid #ccc; background-repeat: no-repeat; background-position: center center; background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAoAAAAKCAYAAACNMs+9AAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAABASURBVChTYxg4wAjE0kC8AoiFQAJYwFcgjocwGRiMgPgdEP9HwyBFDkCMAtAVY1UEAzDFeBXBAEgxQUWUAgYGAEurD5Y3/iOAAAAAAElFTkSuQmCC);",
      action: "ContextMenu",
      menu: taskMenu,
      v: "Hover"
    }
  ];
  // args.row.backColor("#ff6347");
};

// dp.contextMenuLink = new DayPilot.Menu([
//   {
//     text: "Delete",
//     onClick: async (args) => {
//       const id = args.source.id();
//       await DayPilot.Http.post("gantt_link_delete.php", {id});
//       loadLinks();
//     }
//   }
// ]);

dp.onRowCreate = async (args) => {

  const data = {
    name: args.text,
    start: dp.startDate,
    end: dp.startDate.addDays(3)
  };
  await DayPilot.Http.post("gantt_task_create.php", data);
  loadTasks();

};

dp.onTaskMove = async (args) => {

  const data = {
    id: args.task.id(),
    start: args.newStart,
    end: args.newEnd
  };

  await DayPilot.Http.post("gantt_task_move.php", data);
  // dp.message("Updated");

};

dp.onTaskResize = async (args) => {

  const data = {
    id: args.task.id(),
    start: args.newStart,
    end: args.newEnd
  };

  await DayPilot.Http.post("gantt_task_move.php", data);
  // dp.message("Updated");

};


dp.onRowMove = async (args) => {

  const data = {
    source: args.source.id(),
    target: args.target.id(),
    position: args.position
  };

  await DayPilot.Http.post("gantt_row_move.php", data);
  // dp.message("Updated");

};

// dp.onLinkCreate = async (args) => {
//   const data = {
//     from: args.from,
//     to: args.to,
//     type: args.type
//   };
//   await DayPilot.Http.post("gantt_link_create.php", data);
//   loadLinks();
// };

dp.onTaskClick = async (args) => {

  // if (args.task.type() === "Group") {
  //
  //   const modal = DayPilot.Modal.prompt("Name:", args.task.text());
  //
  //   if (modal.canceled) {
  //     return;
  //   }
  //
  //   const data = {
  //     id: args.task.data.id,
  //     name: args.task.data.text,
  //     start: args.task.data.start,
  //     end: args.task.data.end,
  //     complete: args.task.data.complete,
  //     milestone: false
  //   };
  //
  //   await DayPilot.Http.post("gantt_task_update.php", data);
  //
  //   args.task.data.text = modal.result;
  //   dp.tasks.update(args.task);
  //
  //   return;
  // }

  const durations = [];
  for (let i = 1; i <= 10; i++) {
    durations.push({
      name: i + " day" + ((i > 1) ? "s" : ""),
      id: i
    });
  }

  const completes = [];
  for (let i = 0; i <= 100; i += 10) {
    completes.push({
      name: i + "%",
      id: i
    });
  }

  const form = [
    {name: "Name", id: "text"},
    {name: "Start", id: "start", dateFormat: "M/d/yyyy"},
    {name: "Duration", id: "duration", options: durations},
    {name: "Complete", id: "complete", options: completes},
    // {
    //   name: "Type", id: "type", type: "radio", options: [
    //     {
    //       name: "Task", id: "task", children: [
    //         {name: "Duration", id: "duration", options: durations},
    //         {name: "Complete", id: "complete", options: completes},
    //       ]
    //     },
    //     {name: "Milestone", id: "milestone"}
    //   ]
    // }
  ];

  const formData = {
    id: args.task.data.id,
    text: args.task.text(),
    start: args.task.start(),
    complete: args.task.complete(),
    // type: args.task.type().toLowerCase(),
    duration: args.task.duration().totalDays()
  };

  const modal = await DayPilot.Modal.form(form, formData);

  if (modal.canceled) {
    return;
  }

  const data = args.task.data;
  const result = modal.result;

  data.id = result.id;
  data.text = result.text;
  data.start = result.start;


  data.end = new DayPilot.Date(result.start).addDays(result.duration);
  data.complete = result.complete;
  data.type = "Task";


  const postData = {
    id: data.id,
    name: data.text,
    start: data.start,
    end: data.end,
    complete: data.complete,
    // milestone: data.type === "Milestone"
  }

  await DayPilot.Http.post("gantt_task_update.php", postData);
  dp.tasks.update(args.task);

};

// ==== end ====

dp.init();

loadTasks();

// loadLinks();

function loadTasks() {
  dp.tasks.load("gantt_tasks.php");
}

// function loadLinks() {
//   dp.links.load("gantt_links.php");
// }

const taskMenu = new DayPilot.Menu({
  items: [
    {
      text: "Delete",
      onClick: async (args) => {
        const id = args.source.id();
        await DayPilot.Http.post("gantt_task_delete.php", {id});
        loadTasks();
      }
    }
  ]
});
