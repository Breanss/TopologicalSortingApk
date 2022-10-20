let graf;
var numerWierzcholka = 1;
var algorithm;
var startNode;
var width;
var height;
var whitened = "NewNode";
var left;
var right;


function usunGraf() {
    graf.clear();
    numerWierzcholka = 1;
}

function match(edges, edgeinfo) {
    for (var i = 0; i < edges.length; i++) {
        console.log(edges[i], edgeinfo)
        if (edges[i].source == edgeinfo.source && edges[i].target == edgeinfo.target)
            return edges[i].id;
    }
    return false;
}


window.onload = function () {
    document.getElementById(whitened).classList.add('active');
    algorithm = document.getElementById("algorithm");
    left = document.getElementById("left");
    right = document.getElementById("right");


    G6.registerBehavior('click-add-node', {
        getEvents() {
            return {
                'canvas:click': 'onClick',
            };
        },
        onClick(ev) {
            console.log(numerWierzcholka);
            const self = this;
            graf.addItem('node', {
                size: 40,
                x: ev.canvasX,
                y: ev.canvasY,
                id: `${numerWierzcholka}`,
                label: numerWierzcholka
            });
            numerWierzcholka++;
        },
    });


    G6.registerBehavior('click-start-node', {
        getEvents() {

            return {
                'node:click': 'onClick',
            };
        },
        onClick(ev) {
            const self = this;
            const node = ev.item;
            startNode = parseInt(node.getModel().id);
        },
    });

    G6.registerBehavior('click-add-edge', {
        getEvents() {
            return {
                'node:click': 'onClick',
                mousemove: 'onMousemove',
                'edge:click': 'onEdgeClick',
            };
        },
        onClick(ev) {
            const self = this;
            const node = ev.item;
            const model = node.getModel();
            if (self.addingEdge && self.edge) {
                let edges = graf.save().edges;
                let edge = {source: self.edge.getModel().source, target: model.id};
                if (match(edges, edge)) {
                    graf.removeItem(self.edge);
                } else if (edge1 = match(edges, {source: edge.target, target: edge.source})) {
                    var otheredge = graf.findById(edge1);
                    graf.updateItem(self.edge, {
                        target: model.id,
                        type: 'quadratic'
                    });
                    graf.updateItem(otheredge, {
                        type: 'quadratic'
                    });
                } else {
                    graf.updateItem(self.edge, {
                        target: model.id,
                    });
                }
                self.edge = null;
                self.addingEdge = false;
            } else {
                let edgejson = {
                    source: model.id,
                    target: model.id,
                };
                self.edge = graf.addItem('edge', edgejson);
                self.addingEdge = true;
            }
        },
        onMousemove(ev) {
            const self = this;
            const point = {x: ev.x, y: ev.y};
            if (self.addingEdge && self.edge) {
                graf.updateItem(self.edge, {
                    target: point,
                });
            }
        },
        onEdgeClick(ev) {
            const self = this;
            const currentEdge = ev.item;

            if (self.addingEdge && self.edge === currentEdge) {
                graf.removeItem(self.edge);
                self.edge = null;
                self.addingEdge = false;
            }
        },
    });


    G6.registerBehavior('click-delete', {
        // Set the events and the corresponding responsing function for this behavior
        getEvents() {
            return {
                'node:click': 'onNodeClick', // The event is canvas:click, the responsing function is onClick
                'edge:click': 'onEdgeClick', // The event is edge:click, the responsing function is onEdgeClick
            };
        },
        // The responsing function for node:click defined in getEvents
        onNodeClick(ev) {
            const self = this;
            const node = ev.item;
            // The position where the mouse clicks
            var id = parseInt(node.getModel().id);
            var ngraph = {nodes: [], edges: []};
            var data = graf.save();
            graf.clear();
            for (var i = 0; i < data["nodes"].length; i++) {
                if (data["nodes"][i].id > id) {
                    var next = parseInt(data["nodes"][i].id) - 1;
                    data["nodes"][i].label = next;
                    data["nodes"][i].id = next.toString();
                    ngraph.nodes.push(data["nodes"][i]);
                } else if (data["nodes"][i].id < id) ngraph.nodes.push(data["nodes"][i]);
            }
            for (var i = 0; i < data["edges"].length; i++) {
                var source = parseInt(data["edges"][i].source);
                var target = parseInt(data["edges"][i].target);
                if (source == id) continue;
                else if (source > id) data["edges"][i].source = (source - 1).toString();
                if (target == id) continue;
                else if (target > id) data["edges"][i].target = (target - 1).toString();
                ngraph.edges.push(data["edges"][i]);
            }
            graf.data(ngraph);
            graf.render();
            numerWierzcholka--;
        },
        onEdgeClick(ev) {
            const self = this;
            const edge = ev.item;
            const graph = self.graph;
            graf.removeItem(edge);
        }
    });


    const container = document.getElementById('obszarKreatora');

    width = container.scrollWidth;
    height = container.scrollHeight;

    graf = new G6.Graph({
        container: 'obszarKreatora',
        width,
        height,
        modes: {
            move: ['drag-node', 'click-select'],
            addNode: ['click-add-node', 'click-select'],
            addEdge: ['click-add-edge', 'click-select'],
            trash: ['click-delete', 'click-select'],
            startNode: ['click-start-node', 'click-select']
        },
        defaultEdge: {
            type: "line",
            style: {
                lineWidth: 3,
                stroke: '#fff',
                endArrow: {
                    path: G6.Arrow.triangle(8, 10, 6),
                    d: 8,
                }
            },
            labelCfg: {
                refY: 12,
                style: {

                    fontFamily: "Arial",
                    fontSize: 15,
                    fill: '#fff'
                }
            }

        },
        defaultNode: {
            style: {
                fill: '#292929',
                stroke: '#fff',
                lineWidth: 2
            },
            labelCfg: {
                style: {
                    fontFamily: "Arial",
                    fontWeight: 'Bold',
                    fontSize: 17,
                    fill: '#fff',

                }
            }
        },
        defaultCombo: {
            type: 'circle',
            labelCfg: {
                position: 'top',
            }
        }
    });
    graf.render();


    var leftSelectorOnClick = function (type, obj) {
        return function () {
            graf.setMode(type);

        }
    }

    const newNode = document.getElementById('NewNode');
    newNode.onclick = leftSelectorOnClick("addNode", newNode);
    const newEdge = document.getElementById('dodajKrawedz');
    newEdge.onclick = leftSelectorOnClick("addEdge", newEdge);
    const move = document.getElementById('przesun');
    move.onclick = leftSelectorOnClick("move", move);
    const trash = document.getElementById('usunElement');
    trash.onclick = leftSelectorOnClick("trash", trash);

}


