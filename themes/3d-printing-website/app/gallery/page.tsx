import Image from "next/image"
import Link from "next/link"
import { Button } from "@/components/ui/button"
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from "@/components/ui/card"
import { Badge } from "@/components/ui/badge"
import { Input } from "@/components/ui/input"
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from "@/components/ui/select"
import { Navbar } from "@/components/navbar"
import { Footer } from "@/components/footer"
import { Search, Filter, ArrowRight } from "lucide-react"

export default function GalleryPage() {
  const models = [
    {
      id: 1,
      name: "Mechanical Gear Assembly",
      category: "Engineering",
      image: "/placeholder.svg?height=300&width=400",
      material: "PLA+",
      printTime: "8 hours",
      client: "TechCorp Industries",
    },
    {
      id: 2,
      name: "Architectural Model",
      category: "Architecture",
      image: "/placeholder.svg?height=300&width=400",
      material: "Resin",
      printTime: "12 hours",
      client: "Design Studio Pro",
    },
    {
      id: 3,
      name: "Custom Phone Case",
      category: "Consumer",
      image: "/placeholder.svg?height=300&width=400",
      material: "TPU",
      printTime: "3 hours",
      client: "Mobile Accessories Co",
    },
    {
      id: 4,
      name: "Drone Frame",
      category: "Aerospace",
      image: "/placeholder.svg?height=300&width=400",
      material: "Carbon Fiber",
      printTime: "6 hours",
      client: "AeroTech Solutions",
    },
    {
      id: 5,
      name: "Medical Device Prototype",
      category: "Medical",
      image: "/placeholder.svg?height=300&width=400",
      material: "Biocompatible Resin",
      printTime: "10 hours",
      client: "MedInnovate",
    },
    {
      id: 6,
      name: "Jewelry Design",
      category: "Fashion",
      image: "/placeholder.svg?height=300&width=400",
      material: "Gold PLA",
      printTime: "4 hours",
      client: "Luxury Designs Ltd",
    },
    {
      id: 7,
      name: "Automotive Part",
      category: "Automotive",
      image: "/placeholder.svg?height=300&width=400",
      material: "ABS",
      printTime: "7 hours",
      client: "Auto Parts Pro",
    },
    {
      id: 8,
      name: "Educational Model",
      category: "Education",
      image: "/placeholder.svg?height=300&width=400",
      material: "PLA",
      printTime: "5 hours",
      client: "University Research",
    },
    {
      id: 9,
      name: "Gaming Miniature",
      category: "Gaming",
      image: "/placeholder.svg?height=300&width=400",
      material: "Detailed Resin",
      printTime: "8 hours",
      client: "Board Game Studio",
    },
  ]

  const categories = [
    "All",
    "Engineering",
    "Architecture",
    "Consumer",
    "Aerospace",
    "Medical",
    "Fashion",
    "Automotive",
    "Education",
    "Gaming",
  ]

  return (
    <div className="min-h-screen bg-background text-foreground">
      <Navbar />

      <div className="container py-12">
        {/* Header */}
        <div className="text-center space-y-4 mb-12">
          <Badge variant="secondary" className="w-fit mx-auto">
            Project Gallery
          </Badge>
          <h1 className="text-4xl md:text-5xl font-bold">Our Work</h1>
          <p className="text-xl text-muted-foreground max-w-2xl mx-auto">
            Explore our portfolio of successful 3D printing projects across various industries and applications.
          </p>
        </div>

        {/* Filters */}
        <div className="flex flex-col md:flex-row gap-4 mb-12">
          <div className="relative flex-1">
            <Search className="absolute left-3 top-1/2 transform -translate-y-1/2 h-4 w-4 text-muted-foreground" />
            <Input placeholder="Search projects..." className="pl-10" />
          </div>
          <Select defaultValue="All">
            <SelectTrigger className="w-full md:w-48">
              <Filter className="h-4 w-4 mr-2" />
              <SelectValue placeholder="Category" />
            </SelectTrigger>
            <SelectContent>
              {categories.map((category) => (
                <SelectItem key={category} value={category}>
                  {category}
                </SelectItem>
              ))}
            </SelectContent>
          </Select>
          <Select defaultValue="newest">
            <SelectTrigger className="w-full md:w-48">
              <SelectValue placeholder="Sort by" />
            </SelectTrigger>
            <SelectContent>
              <SelectItem value="newest">Newest First</SelectItem>
              <SelectItem value="oldest">Oldest First</SelectItem>
              <SelectItem value="name">Name A-Z</SelectItem>
              <SelectItem value="category">Category</SelectItem>
            </SelectContent>
          </Select>
        </div>

        {/* Gallery Grid */}
        <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
          {models.map((model) => (
            <Card key={model.id} className="group hover:shadow-lg transition-all duration-300 border-border/50">
              <div className="relative overflow-hidden rounded-t-lg">
                <Image
                  src={model.image || "/placeholder.svg"}
                  alt={model.name}
                  width={400}
                  height={300}
                  className="w-full h-64 object-cover group-hover:scale-105 transition-transform duration-300"
                />
                <Badge className="absolute top-4 left-4">{model.category}</Badge>
              </div>
              <CardHeader>
                <CardTitle className="group-hover:text-primary transition-colors">{model.name}</CardTitle>
                <CardDescription>Client: {model.client}</CardDescription>
              </CardHeader>
              <CardContent>
                <div className="space-y-2 mb-4">
                  <div className="flex justify-between text-sm">
                    <span className="text-muted-foreground">Material:</span>
                    <span>{model.material}</span>
                  </div>
                  <div className="flex justify-between text-sm">
                    <span className="text-muted-foreground">Print Time:</span>
                    <span>{model.printTime}</span>
                  </div>
                </div>
                <Button variant="outline" size="sm" asChild className="w-full bg-transparent">
                  <Link href={`/models/${model.id}`}>
                    View Details <ArrowRight className="ml-2 h-3 w-3" />
                  </Link>
                </Button>
              </CardContent>
            </Card>
          ))}
        </div>

        {/* Load More */}
        <div className="text-center">
          <Button variant="outline" size="lg">
            Load More Projects
          </Button>
        </div>
      </div>

      <Footer />
    </div>
  )
}
