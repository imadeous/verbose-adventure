import Image from "next/image"
import Link from "next/link"
import { Button } from "@/components/ui/button"
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from "@/components/ui/card"
import { Badge } from "@/components/ui/badge"
import { Separator } from "@/components/ui/separator"
import { Navbar } from "@/components/navbar"
import { Footer } from "@/components/footer"
import { ArrowLeft, User, Download, Share2 } from "lucide-react"

// This would typically come from a database or API
const getModelData = (id: string) => {
  const models = {
    "1": {
      id: 1,
      name: "Mechanical Gear Assembly",
      category: "Engineering",
      images: [
        "/placeholder.svg?height=600&width=800",
        "/placeholder.svg?height=400&width=600",
        "/placeholder.svg?height=400&width=600",
        "/placeholder.svg?height=400&width=600",
      ],
      material: "PLA+",
      printTime: "8 hours",
      client: "TechCorp Industries",
      completedDate: "2024-01-15",
      dimensions: "120 x 80 x 45 mm",
      layerHeight: "0.2mm",
      infill: "20%",
      supports: "Yes",
      postProcessing: "Sanding, Assembly",
      description:
        "A complex mechanical gear assembly designed for industrial automation equipment. This project required precise tolerances and smooth operation between moving parts. The design was optimized for 3D printing with minimal support structures while maintaining structural integrity.",
      challenges:
        "The main challenge was achieving the required tolerances for the gear teeth while ensuring smooth rotation. We used specialized support structures and post-processing techniques to achieve the desired finish.",
      specifications: [
        { label: "Material", value: "PLA+" },
        { label: "Print Time", value: "8 hours" },
        { label: "Layer Height", value: "0.2mm" },
        { label: "Infill Density", value: "20%" },
        { label: "Supports", value: "Yes" },
        { label: "Dimensions", value: "120 x 80 x 45 mm" },
        { label: "Post-Processing", value: "Sanding, Assembly" },
      ],
    },
  }

  return models[id as keyof typeof models] || null
}

export default function ModelDetailPage({ params }: { params: { id: string } }) {
  const model = getModelData(params.id)

  if (!model) {
    return (
      <div className="min-h-screen bg-background text-foreground">
        <Navbar />
        <div className="container py-20 text-center">
          <h1 className="text-2xl font-bold mb-4">Model Not Found</h1>
          <p className="text-muted-foreground mb-8">The requested model could not be found.</p>
          <Button asChild>
            <Link href="/gallery">
              <ArrowLeft className="mr-2 h-4 w-4" />
              Back to Gallery
            </Link>
          </Button>
        </div>
        <Footer />
      </div>
    )
  }

  return (
    <div className="min-h-screen bg-background text-foreground">
      <Navbar />

      <div className="container py-8">
        {/* Breadcrumb */}
        <div className="flex items-center space-x-2 text-sm text-muted-foreground mb-8">
          <Link href="/" className="hover:text-primary">
            Home
          </Link>
          <span>/</span>
          <Link href="/gallery" className="hover:text-primary">
            Gallery
          </Link>
          <span>/</span>
          <span className="text-foreground">{model.name}</span>
        </div>

        {/* Back Button */}
        <Button variant="outline" asChild className="mb-8 bg-transparent">
          <Link href="/gallery">
            <ArrowLeft className="mr-2 h-4 w-4" />
            Back to Gallery
          </Link>
        </Button>

        <div className="grid lg:grid-cols-2 gap-12">
          {/* Images */}
          <div className="space-y-4">
            <div className="relative aspect-[4/3] overflow-hidden rounded-lg">
              <Image src={model.images[0] || "/placeholder.svg"} alt={model.name} fill className="object-cover" />
            </div>
            <div className="grid grid-cols-3 gap-4">
              {model.images.slice(1).map((image, index) => (
                <div key={index} className="relative aspect-[4/3] overflow-hidden rounded-lg">
                  <Image
                    src={image || "/placeholder.svg"}
                    alt={`${model.name} view ${index + 2}`}
                    fill
                    className="object-cover hover:scale-105 transition-transform cursor-pointer"
                  />
                </div>
              ))}
            </div>
          </div>

          {/* Details */}
          <div className="space-y-8">
            <div className="space-y-4">
              <div className="flex items-center justify-between">
                <Badge>{model.category}</Badge>
                <div className="flex items-center space-x-2">
                  <Button variant="outline" size="sm">
                    <Share2 className="h-4 w-4 mr-2" />
                    Share
                  </Button>
                  <Button variant="outline" size="sm">
                    <Download className="h-4 w-4 mr-2" />
                    Download
                  </Button>
                </div>
              </div>
              <h1 className="text-3xl md:text-4xl font-bold">{model.name}</h1>
              <p className="text-muted-foreground text-lg">{model.description}</p>
            </div>

            {/* Client Info */}
            <Card className="border-border/50">
              <CardHeader>
                <CardTitle className="flex items-center space-x-2">
                  <User className="h-5 w-5 text-primary" />
                  <span>Project Information</span>
                </CardTitle>
              </CardHeader>
              <CardContent className="space-y-4">
                <div className="flex justify-between">
                  <span className="text-muted-foreground">Client:</span>
                  <span className="font-medium">{model.client}</span>
                </div>
                <div className="flex justify-between">
                  <span className="text-muted-foreground">Completed:</span>
                  <span className="font-medium">{new Date(model.completedDate).toLocaleDateString()}</span>
                </div>
                <div className="flex justify-between">
                  <span className="text-muted-foreground">Category:</span>
                  <Badge variant="secondary">{model.category}</Badge>
                </div>
              </CardContent>
            </Card>

            {/* Specifications */}
            <Card className="border-border/50">
              <CardHeader>
                <CardTitle>Technical Specifications</CardTitle>
              </CardHeader>
              <CardContent>
                <div className="space-y-3">
                  {model.specifications.map((spec, index) => (
                    <div key={index} className="flex justify-between">
                      <span className="text-muted-foreground">{spec.label}:</span>
                      <span className="font-medium">{spec.value}</span>
                    </div>
                  ))}
                </div>
              </CardContent>
            </Card>

            {/* Challenges */}
            <Card className="border-border/50">
              <CardHeader>
                <CardTitle>Project Challenges</CardTitle>
              </CardHeader>
              <CardContent>
                <p className="text-muted-foreground">{model.challenges}</p>
              </CardContent>
            </Card>

            {/* CTA */}
            <div className="space-y-4">
              <Separator />
              <div className="text-center space-y-4">
                <h3 className="text-xl font-semibold">Need a Similar Project?</h3>
                <p className="text-muted-foreground">Get in touch with us to discuss your 3D printing requirements.</p>
                <div className="flex flex-col sm:flex-row gap-4">
                  <Button asChild className="flex-1">
                    <Link href="/quote">Get Quote</Link>
                  </Button>
                  <Button variant="outline" asChild className="flex-1 bg-transparent">
                    <Link href="/contact">Contact Us</Link>
                  </Button>
                </div>
              </div>
            </div>
          </div>
        </div>

        {/* Related Projects */}
        <div className="mt-20">
          <h2 className="text-2xl font-bold mb-8">Related Projects</h2>
          <div className="grid md:grid-cols-3 gap-8">
            {[
              {
                id: 2,
                name: "Architectural Model",
                category: "Architecture",
                image: "/placeholder.svg?height=300&width=400",
                material: "Resin",
              },
              {
                id: 3,
                name: "Custom Phone Case",
                category: "Consumer",
                image: "/placeholder.svg?height=300&width=400",
                material: "TPU",
              },
              {
                id: 4,
                name: "Drone Frame",
                category: "Aerospace",
                image: "/placeholder.svg?height=300&width=400",
                material: "Carbon Fiber",
              },
            ].map((relatedModel) => (
              <Card
                key={relatedModel.id}
                className="group hover:shadow-lg transition-all duration-300 border-border/50"
              >
                <div className="relative overflow-hidden rounded-t-lg">
                  <Image
                    src={relatedModel.image || "/placeholder.svg"}
                    alt={relatedModel.name}
                    width={400}
                    height={300}
                    className="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300"
                  />
                  <Badge className="absolute top-4 left-4">{relatedModel.category}</Badge>
                </div>
                <CardHeader>
                  <CardTitle className="group-hover:text-primary transition-colors">{relatedModel.name}</CardTitle>
                  <CardDescription>Material: {relatedModel.material}</CardDescription>
                </CardHeader>
                <CardContent>
                  <Button variant="outline" size="sm" asChild>
                    <Link href={`/models/${relatedModel.id}`}>View Details</Link>
                  </Button>
                </CardContent>
              </Card>
            ))}
          </div>
        </div>
      </div>

      <Footer />
    </div>
  )
}
