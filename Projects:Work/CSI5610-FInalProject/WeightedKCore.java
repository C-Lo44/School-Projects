// Copy and Paste, Compilie Code Do -> javac WeightedKCore.java
// You probably need to fix the path you want the output text files to be sent to: Then -> java WeightedKCore test.g "C:\VS Code\CSI5610-FinalProject\OutputCore.txt" "C:\VS Code\CSI5610-FinalProject\OutputCoreness.txt"
// This one checks the example one, make sure to correct the output path of the two files -> java WeightedKCore example.g "C:\VS Code\CSI5610-FinalProject\OutputCore.txt" "C:\VS Code\CSI5610-FinalProject\OutputCoreness.txt"
import java.io.*;
import java.util.*;

public class WeightedKCore {

    static class Node {
        int id;
        String name;
        double weightedDegree;
        Set<Edge> edges = new HashSet<>();
        int coreness;

        Node(int id, String name) {
            this.id = id;
            this.name = name;
        }
    }

    static class Edge {
        Node from;
        Node to;
        double weight;

        Edge(Node from, Node to, double weight) {
            this.from = from;
            this.to = to;
            this.weight = weight;
        }
    }

    static class Graph {
        Map<Integer, Node> nodes = new HashMap<>();

        void addVertex(int id, String name) {
            nodes.put(id, new Node(id, name));
        }

        void addEdge(int fromId, int toId, double weight) {
            Node from = nodes.get(fromId);
            Node to = nodes.get(toId);
            Edge edge = new Edge(from, to, weight);
            from.edges.add(edge);
            to.edges.add(edge);
        }

        void calculateWeightedDegrees() {
            for (Node node : nodes.values()) {
                double sumWeights = node.edges.stream().mapToDouble(e -> e.weight).sum();
                node.weightedDegree = Math.sqrt(node.edges.size() * sumWeights);
            }
        }

        void updateWeightedDegree(Node node) {
            double sumWeights = node.edges.stream().mapToDouble(e -> e.weight).sum();
            node.weightedDegree = Math.sqrt(node.edges.size() * sumWeights);
        }

        List<Set<Node>> decompose() {
            List<Set<Node>> cores = new ArrayList<>();
            Map<Node, Double> degrees = new HashMap<>();
            for (Node node : nodes.values()) {
                degrees.put(node, node.weightedDegree);
            }

            int k = 0;
            while (!nodes.isEmpty()) {
                Set<Node> core = new HashSet<>();
                Queue<Node> queue = new LinkedList<>();

                for (Node node : nodes.values()) {
                    if (degrees.get(node) < k + 1) {
                        queue.add(node);
                    }
                }

                while (!queue.isEmpty()) {
                    Node node = queue.poll();
                    for (Edge edge : new ArrayList<>(node.edges)) {
                        Node neighbor = edge.from.equals(node) ? edge.to : edge.from;
                        neighbor.edges.remove(edge);
                        updateWeightedDegree(neighbor);
                        degrees.put(neighbor, neighbor.weightedDegree);
                        if (degrees.get(neighbor) < k + 1 && !core.contains(neighbor)) {
                            queue.add(neighbor);
                        }
                    }
                    core.add(node);
                    nodes.remove(node.id);
                }

                if (!core.isEmpty()) {
                    for (Node node : core) {
                        node.coreness = k;
                    }
                    cores.add(core);
                }
                k++;
            }
            return cores;
        }
    }

    public static void main(String[] args) throws IOException {
        if (args.length < 3) {
            System.out.println("Usage: java WeightedKCore <inputFile> <outputCoreFile> <outputCorenessFile>");
            return;
        }

        String inputFile = args[0];
        String outputCoreFile = args[1];
        String outputCorenessFile = args[2];

        Graph graph = new Graph();
        try (BufferedReader br = new BufferedReader(new FileReader(inputFile))) {
            String line;
            while ((line = br.readLine()) != null) {
                if (line.startsWith("*Vertices")) {
                    // Read vertices
                    while (!(line = br.readLine()).startsWith("*Edges")) {
                        String[] parts = line.split(" ");
                        int id = Integer.parseInt(parts[0]);
                        String name = parts[1].replace("\"", "");
                        graph.addVertex(id, name);
                    }
                }
                if (line.startsWith("*Edges")) {
                    // Read edges
                    while ((line = br.readLine()) != null) {
                        String[] parts = line.split(" ");
                        if (parts.length != 3) {
                            continue;
                        }
                        try {
                            int from = Integer.parseInt(parts[0]);
                            int to = Integer.parseInt(parts[1]);
                            double weight = Double.parseDouble(parts[2]);
                            graph.addEdge(from, to, weight);
                        } catch (NumberFormatException e) {
                            System.err.println("Skipping line: " + line);
                        }
                    }
                }
            }
        }

        graph.calculateWeightedDegrees();
        List<Set<Node>> cores = graph.decompose();

        // Create a map to store all nodes included in each k-core
        Map<Integer, Set<Node>> kCoreMap = new HashMap<>();
        for (int k = 0; k < cores.size(); k++) {
            Set<Node> core = cores.get(k);
            kCoreMap.put(k, new HashSet<>(core));
            for (int j = 0; j < k; j++) {
                kCoreMap.get(j).addAll(core);
            }
        }

        try (BufferedWriter coreWriter = new BufferedWriter(new FileWriter(outputCoreFile));
             BufferedWriter corenessWriter = new BufferedWriter(new FileWriter(outputCorenessFile))) {

            // Write the coreness values
            corenessWriter.write("vertexName wcoreness\n");

            List<Node> allNodes = new ArrayList<>();
            for (Set<Node> core : cores) {
                allNodes.addAll(core);
            }
            allNodes.sort(Comparator.comparingInt(node -> node.id)); // Sort by vertex ID
            for (Node node : allNodes) {
                corenessWriter.write(node.name + " " + node.coreness + "\n");
            }

            // Write the k-core decomposition
            coreWriter.write("weighted k-cores\n");
            for (int k = 0; k < kCoreMap.size(); k++) {
                Set<Node> core = kCoreMap.get(k);
                coreWriter.write(k + "-core: ");
                List<Node> sortedNodes = new ArrayList<>(core);
                sortedNodes.sort(Comparator.comparingInt(node -> node.id)); // Sort by vertex ID
                for (Node node : sortedNodes) {
                    coreWriter.write(node.name + ",");
                }
                coreWriter.write("\n");
            }
        }

        // Verify the contents of the output files
        System.out.println("Contents of the output core file:");
        try (BufferedReader br = new BufferedReader(new FileReader(outputCoreFile))) {
            String line;
            while ((line = br.readLine()) != null) {
                System.out.println(line);
            }
        }

        System.out.println("Contents of the output coreness file:");
        try (BufferedReader br = new BufferedReader(new FileReader(outputCorenessFile))) {
            String line;
            while ((line = br.readLine()) != null) {
                System.out.println(line);
            }
        }
    }
}
